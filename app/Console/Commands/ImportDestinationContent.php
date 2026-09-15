<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Support\SafariContent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('destination:import-content')]
#[Description('Backfill destination rich content from the static tour map (idempotent, never overwrites)')]
class ImportDestinationContent extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $updated = 0;
        $created = 0;
        $skipped = 0;

        foreach (SafariContent::contentTours() as $key => $t) {
            $dest = $this->matchDestination($key, $t);

            if (! $dest) {
                $skipped++;

                continue;
            }

            [$dest, $touched] = $this->fillFromCode($dest, $t);

            if ($touched) {
                $dest->save();
                $updated++;
                $this->line("  updated: {$dest->slug}");
            } else {
                $skipped++;
            }
            $created += $touched ? 0 : 0;
        }

        $this->info("Backfill complete. Updated {$updated}, skipped {$skipped}.");

        return self::SUCCESS;
    }

    /**
     * Locate the DB destination for a content-map entry.
     */
    private function matchDestination(string $key, array $t): ?Destination
    {
        $dbId = $t['db']['id'] ?? null;

        if ($dbId !== null) {
            $dest = Destination::find((int) $dbId);

            return $dest ?: null;
        }

        return Destination::where('slug', $key)->first();
    }

    /**
     * Copy static content into any empty columns on the destination.
     *
     * @return array{0: Destination, 1: bool}
     */
    private function fillFromCode(Destination $dest, array $t): array
    {
        $data = [];

        foreach ([
            'long_description' => $t['overview'] ?? null,
            'location' => $t['location'] ?? null,
            'rating' => $t['rating'] ?? null,
            'includes' => $t['included'] ?? null,
            'excluded' => $t['excluded'] ?? null,
            'highlights' => $t['highlights'] ?? null,
            'itinerary' => $t['itinerary'] ?? null,
            'faqs' => $t['faqs'] ?? null,
        ] as $column => $value) {
            if ($this->isEmptyColumn($dest, $column) && ! blank($value)) {
                $data[$column] = $value;
            }
        }

        // Quick facts: converted from the assoc shape the front-end consumes.
        $quickFacts = [];
        foreach ($t['quickFacts'] ?? [] as $label => $value) {
            $quickFacts[] = ['label' => (string) $label, 'value' => (string) $value];
        }
        if ($this->isEmptyColumn($dest, 'quick_facts') && $quickFacts) {
            $data['quick_facts'] = $quickFacts;
        }

        // Gallery: resolved to absolute Cloudinary URLs so the DB row is self-contained.
        $gallery = [];
        foreach ($t['gallery'] ?? [] as $g) {
            $g = trim((string) $g);
            if ($g === '') {
                continue;
            }
            $gallery[] = isset(SafariContent::F[$g]) ? SafariContent::cld(SafariContent::F[$g], 700) : $g;
        }
        if ($this->isEmptyColumn($dest, 'gallery') && $gallery) {
            $data['gallery'] = $gallery;
        }

        foreach ($data as $column => $value) {
            $dest->{$column} = $value;
        }

        return [$dest, ! empty($data)];
    }

    /**
     * True when the stored value is null, empty string, or an empty array.
     */
    private function isEmptyColumn(Destination $dest, string $column): bool
    {
        $value = $dest->{$column} ?? null;

        if ($value === null || $value === '') {
            return true;
        }

        if (is_array($value) && count($value) === 0) {
            return true;
        }

        return false;
    }
}