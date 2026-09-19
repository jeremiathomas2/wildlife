<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Support\SafariContent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('destination:sync')]
#[Description('Create/update every static tour as a fully-managed CMS destination (creates missing rows, backfills rich content, applies listing categories)')]
class SyncDestinationContent extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach (SafariContent::contentTours() as $key => $t) {
            $dest = $this->matchDestination($key, $t);

            if (! $dest) {
                $dest = Destination::create($this->dataForNew($key, $t));
                $created++;
                $this->line("  created: {$dest->slug}");

                continue;
            }

            [$dest, $touched] = $this->backfill($dest, $t);
            if ($touched) {
                $dest->save();
                $updated++;
                $this->line("  updated: {$dest->slug}");
            } else {
                $skipped++;
            }
        }

        // Normalize legacy category labels on any remaining rows so the CMS dropdown matches.
        $normalized = $this->normalizeLegacyCategories();

        $this->info("Sync complete. Created {$created}, updated {$updated}, skipped {$skipped}, legacy categories normalized {$normalized}.");

        return self::SUCCESS;
    }

    /**
     * Locate the DB destination for a content-map entry (by db id, then by slug == key).
     */
    private function matchDestination(string $key, array $t): ?Destination
    {
        $dbId = $t['db']['id'] ?? null;
        if ($dbId !== null) {
            $byId = Destination::find((int) $dbId);

            return $byId ?: null;
        }

        return Destination::where('slug', $key)->first();
    }

    /**
     * Build a fully-populated row for a destination that has no CMS record yet.
     */
    private function dataForNew(string $key, array $t): array
    {
        $adult = (float) ($t['db']['adult'] ?? $t['price'] ?? 0);
        $child = (float) ($t['db']['child'] ?? ($adult / 2));
        $gallery = $this->resolveGallery($t['gallery'] ?? []);
        $image = $gallery[0] ?? SafariContent::cld(SafariContent::F['safariSerengeti'], 900);
        $overview = $t['overview'] ?? '';
        $quickFacts = [];
        foreach ($t['quickFacts'] ?? [] as $label => $value) {
            $quickFacts[] = ['label' => (string) $label, 'value' => (string) $value];
        }

        return [
            'name' => ucwords(str_replace(['-', '_'], ' ', $key)),
            'slug' => $key,
            'category' => $t['category'] ?? 'day-trip',
            'status' => 'Published',
            'duration' => $this->durationFromDays((int) ($t['durationDays'] ?? 1)),
            'location' => $t['location'] ?? null,
            'price' => $adult,
            'price_adult' => $adult,
            'price_child' => $child ?: null,
            'rating' => isset($t['rating']) ? (float) $t['rating'] : null,
            'image' => $image,
            'desc' => Str::limit(strip_tags($overview), 160),
            'long_description' => $overview ?: null,
            'quick_facts' => $quickFacts ?: null,
            'highlights' => $t['highlights'] ?? null,
            'itinerary' => $t['itinerary'] ?? null,
            'includes' => $t['included'] ?? null,
            'excluded' => $t['excluded'] ?? null,
            'faqs' => $t['faqs'] ?? null,
            'gallery' => $gallery ?: null,
            'reviews' => $this->normalizeReviews($t['reviews'] ?? []),
        ];
    }

    /**
     * Fill empty columns on an existing destination from the static map.
     * The listing category is always corrected (mirrors admin expectations).
     *
     * @return array{0: Destination, 1: bool}
     */
    private function backfill(Destination $dest, array $t): array
    {
        $data = [];

        $scalars = [
            'duration' => $this->durationFromDays((int) ($t['durationDays'] ?? 1)),
            'location' => $t['location'] ?? null,
            'rating' => isset($t['rating']) ? (float) $t['rating'] : null,
            'long_description' => $t['overview'] ?? null,
            'desc' => isset($t['overview']) ? Str::limit(strip_tags($t['overview']), 160) : null,
        ];
        foreach ($scalars as $column => $value) {
            if ($this->isEmptyColumn($dest, $column) && ! blank($value)) {
                $data[$column] = $value;
            }
        }

        $priceColumns = ['price_adult' => 'adult', 'price_child' => 'child'];
        foreach ($priceColumns as $column => $source) {
            if ($this->isEmptyColumn($dest, $column)) {
                $fallback = $source === 'adult'
                    ? ($t['db']['adult'] ?? $t['price'] ?? null)
                    : ($t['db']['child'] ?? null);
                if (! blank($fallback)) {
                    $data[$column] = (float) $fallback;
                }
            }
        }
        if ($this->isEmptyColumn($dest, 'price') && ! empty($data['price_adult'])) {
            $data['price'] = $data['price_adult'];
        }

        if ($this->isEmptyColumn($dest, 'name') && ! empty($t['title'])) {
            $data['name'] = $t['title'];
        }

        // Right-hand sections — only fill when the CMS field is empty.
        $arrays = [
            'highlights' => $t['highlights'] ?? null,
            'itinerary' => $t['itinerary'] ?? null,
            'includes' => $t['included'] ?? null,
            'excluded' => $t['excluded'] ?? null,
            'faqs' => $t['faqs'] ?? null,
        ];
        foreach ($arrays as $column => $value) {
            if ($this->isEmptyColumn($dest, $column) && ! blank($value)) {
                $data[$column] = $value;
            }
        }

        $quickFacts = [];
        foreach ($t['quickFacts'] ?? [] as $label => $value) {
            $quickFacts[] = ['label' => (string) $label, 'value' => (string) $value];
        }
        if ($this->isEmptyColumn($dest, 'quick_facts') && $quickFacts) {
            $data['quick_facts'] = $quickFacts;
        }

        $gallery = $this->resolveGallery($t['gallery'] ?? []);
        if ($this->isEmptyColumn($dest, 'gallery') && $gallery) {
            $data['gallery'] = $gallery;
        }

        $reviews = $this->normalizeReviews($t['reviews'] ?? []);
        if ($this->isEmptyColumn($dest, 'reviews') && $reviews) {
            $data['reviews'] = $reviews;
        }

        // Category: always apply the correct listing token (admin relies on it).
        if (! empty($t['category']) && (string) $dest->category !== $t['category']) {
            $data['category'] = $t['category'];
        }

        foreach ($data as $column => $value) {
            $dest->{$column} = $value;
        }

        return [$dest, ! empty($data)];
    }

    /**
     * Convert legacy "Day Trip" / "Multi-Day Safari" labels to listing tokens on every row.
     */
    private function normalizeLegacyCategories(): int
    {
        $count = 0;
        foreach (Destination::all() as $dest) {
            $mapped = SafariContent::listingCategory($dest->category);
            $legacy = is_string($dest->category) && in_array(strtolower(trim($dest->category)), ['day trip', 'multi-day safari', 'multi-day'], true);
            if ($legacy && (string) $dest->category !== $mapped) {
                $dest->category = $mapped;
                $dest->save();
                $count++;
            }
        }

        return $count;
    }

    /**
     * Resolve gallery entries (Cloudinary keys or raw URLs) to absolute URLs.
     */
    private function resolveGallery($arr): array
    {
        $out = [];
        foreach (is_array($arr) ? $arr : [] as $g) {
            $g = trim((string) $g);
            if ($g === '') {
                continue;
            }
            $out[] = isset(SafariContent::F[$g]) ? SafariContent::cld(SafariContent::F[$g], 700) : $g;
        }

        return $out;
    }

    /**
     * Keep only review rows with non-blank text.
     */
    private function normalizeReviews($arr): array
    {
        $out = [];
        foreach (is_array($arr) ? $arr : [] as $row) {
            if (! is_array($row)) {
                continue;
            }
            $text = trim((string) ($row['text'] ?? ''));
            if ($text === '') {
                continue;
            }
            $out[] = [
                'author' => trim((string) ($row['author'] ?? '')),
                'country' => trim((string) ($row['country'] ?? '')),
                'text' => $text,
            ];
        }

        return $out;
    }

    private function isEmptyColumn(Destination $dest, string $column): bool
    {
        $value = $dest->{$column} ?? null;
        if ($value === null || $value === '') {
            return true;
        }

        return is_array($value) && count($value) === 0;
    }

    private function durationFromDays(int $days): string
    {
        return $days > 1 ? $days.' Days / '.($days - 1).' Nights' : '1 Day';
    }
}