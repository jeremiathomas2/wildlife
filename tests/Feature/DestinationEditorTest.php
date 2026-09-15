<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Destination;
use App\Support\SafariContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestinationEditorTest extends TestCase
{
    use RefreshDatabase;

    private function authAdmin(): AdminUser
    {
        $admin = AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $this->withSession([
            'admin_logged_in' => true,
            'admin_user_id' => $admin->id,
            'admin_last_activity' => time(),
        ]);

        return $admin;
    }

    private function createDestination(array $overrides = []): Destination
    {
        return Destination::create(array_merge([
            'name' => 'Serengeti Safari',
            'slug' => 'serengeti-safari',
            'category' => 'Multi-Day Safari',
            'duration' => '3 Days',
            'price' => 700,
            'price_adult' => 700,
            'price_child' => 350,
            'status' => 'Published',
            'image' => 'https://example.com/cover.jpg',
            'desc' => 'A great safari',
        ], $overrides));
    }

    private function builtTour(string $slug): ?array
    {
        $tours = SafariContent::buildTours(Destination::where('status', 'Published')->get());

        return collect($tours)->first(fn ($t) => $t['slug'] === $slug);
    }

    public function test_guests_are_redirected_from_destination_editor(): void
    {
        $dest = $this->createDestination();

        $this->get(route('admin.destinations.edit', $dest->id))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_open_destination_editor(): void
    {
        $dest = $this->createDestination();
        $this->authAdmin();

        $this->get(route('admin.destinations.edit', $dest->id))
            ->assertOk()
            ->assertSee('Destination name')
            ->assertSee('About This Tour')
            ->assertSee('Detailed Itinerary')
            ->assertSee('Save destination');
    }

    public function test_admin_update_persists_rich_content(): void
    {
        $dest = $this->createDestination();
        $this->authAdmin();

        $this->put(route('admin.destinations.update', $dest->id), [
            'name' => 'Serengeti Classic',
            'category' => 'safari',
            'status' => 'Published',
            'duration' => '3 Days / 2 Nights',
            'location' => 'Serengeti • Ngorongoro',
            'price_adult' => 750,
            'price_child' => 375,
            'rating' => '4.9',
            'image' => 'https://example.com/cover.jpg',
            'desc' => 'A great safari',
            'long_description' => '<p>DB-driven overview body.</p>',
            'quick_facts' => [
                ['label' => 'Duration', 'value' => '3 Days'],
                ['label' => 'Group Type', 'value' => 'Private'],
            ],
            'highlights' => [
                ['icon' => 'fa-lion', 'text' => 'Big Cats'],
                ['icon' => 'fa-mountain', 'text' => 'Ngorongoro Crater'],
            ],
            'itinerary' => [
                ['label' => 'DAY 01', 'title' => 'Game Drive', 'desc' => 'Full morning drive.', 'activities' => 'Game drive', 'meals' => 'Lunch', 'accommodation' => 'Lodge'],
            ],
            'includes' => ['Park fees', 'Guide'],
            'excluded' => ['Visa', 'Tips'],
            'faqs' => [
                ['q' => 'Is it private?', 'a' => 'Yes.'],
            ],
            'gallery' => ['https://example.com/a.jpg', 'https://example.com/b.jpg'],
            'meta_title' => 'Custom SEO title',
        ])->assertSessionHas('success');

        $dest->refresh();

        $this->assertSame('safari', $dest->category);
        $this->assertSame('Serengeti • Ngorongoro', $dest->location);
        $this->assertSame('<p>DB-driven overview body.</p>', $dest->long_description);
        $this->assertSame([['label' => 'Duration', 'value' => '3 Days'], ['label' => 'Group Type', 'value' => 'Private']], $dest->quick_facts);
        $this->assertSame([['icon' => 'fa-lion', 'text' => 'Big Cats'], ['icon' => 'fa-mountain', 'text' => 'Ngorongoro Crater']], $dest->highlights);
        $this->assertSame('Yes.', $dest->faqs[0]['a']);
        $this->assertSame(['Park fees', 'Guide'], $dest->includes);
        $this->assertSame(['Visa', 'Tips'], $dest->excluded);
        $this->assertSame('Custom SEO title', $dest->meta_title);
    }

    public function test_partial_update_never_blank_existing_rich_content(): void
    {
        $dest = $this->createDestination([
            'long_description' => 'Existing overview',
            'highlights' => [['icon' => 'fa-water', 'text' => 'Waterfall']],
            'faqs' => [['q' => 'Q?', 'a' => 'A!']],
        ]);
        $this->authAdmin();

        $this->put(route('admin.destinations.update', $dest->id), [
            'name' => 'Serengeti Safari',
            'category' => 'Multi-Day Safari',
            'status' => 'Published',
            'duration' => '3 Days',
            'price_adult' => 700,
            'price_child' => 350,
        ])->assertSessionHas('success');

        $dest->refresh();

        $this->assertSame('Existing overview', $dest->long_description);
        $this->assertSame([['icon' => 'fa-water', 'text' => 'Waterfall']], $dest->highlights);
        $this->assertSame([['q' => 'Q?', 'a' => 'A!']], $dest->faqs);
    }

    public function test_update_normalizes_blank_repeater_rows(): void
    {
        $dest = $this->createDestination();
        $this->authAdmin();

        $this->put(route('admin.destinations.update', $dest->id), [
            'name' => 'Serengeti Safari',
            'category' => 'Multi-Day Safari',
            'status' => 'Published',
            'duration' => '3 Days',
            'highlights' => [
                ['icon' => '', 'text' => ''],
                ['icon' => 'fa-camera', 'text' => 'Photography'],
            ],
            'gallery' => ['', 'https://example.com/photo.jpg'],
        ])->assertSessionHas('success');

        $dest->refresh();

        $this->assertSame([['icon' => 'fa-camera', 'text' => 'Photography']], $dest->highlights);
        $this->assertSame(['https://example.com/photo.jpg'], $dest->gallery);
    }

    public function test_admin_can_add_destination_with_full_rich_content(): void
    {
        $this->authAdmin();

        $response = $this->postJson(route('admin.destinations.store'), [
            'name' => 'Chemka Hot Springs',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => 'Full day',
            'location' => 'Moshi, Kilimanjaro',
            'price_adult' => 80,
            'price_child' => 40,
            'rating' => '4.8',
            'image' => 'https://example.com/chemka.jpg',
            'desc' => 'Swim in crystal-clear natural pools.',
            'long_description' => '<p>Kikuletwa hot springs day trip.</p>',
            'quick_facts' => [
                ['label' => 'Duration', 'value' => '1 Day'],
                ['label' => 'Pickup', 'value' => 'Moshi'],
            ],
            'highlights' => [
                ['icon' => 'fa-swimmer', 'text' => 'Natural Pools'],
            ],
            'itinerary' => [
                ['label' => '09:00', 'title' => 'Pickup', 'desc' => 'Drive to springs.', 'activities' => 'Transfer', 'meals' => 'Lunch', 'accommodation' => ''],
            ],
            'includes' => ['Transport', 'Lunch'],
            'excluded' => ['Tips'],
            'faqs' => [
                ['q' => 'Is lunch included?', 'a' => 'Yes.'],
            ],
            'gallery' => ['https://example.com/chemka-1.jpg'],
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Destination added!',
            ]);

        $dest = Destination::where('name', 'Chemka Hot Springs')->firstOrFail();

        $this->assertSame('Full day', $dest->duration);
        $this->assertSame('Moshi, Kilimanjaro', $dest->location);
        $this->assertSame('4.8', (string) $dest->rating);
        $this->assertSame('<p>Kikuletwa hot springs day trip.</p>', $dest->long_description);
        $this->assertSame([['label' => 'Duration', 'value' => '1 Day'], ['label' => 'Pickup', 'value' => 'Moshi']], $dest->quick_facts);
        $this->assertSame([['icon' => 'fa-swimmer', 'text' => 'Natural Pools']], $dest->highlights);
        $this->assertSame('Pickup', $dest->itinerary[0]['title']);
        $this->assertSame(['Transport', 'Lunch'], $dest->includes);
        $this->assertSame(['Tips'], $dest->excluded);
        $this->assertSame('Yes.', $dest->faqs[0]['a']);
        $this->assertSame(['https://example.com/chemka-1.jpg'], $dest->gallery);

        // Appears on the live site.
        $this->get('/')->assertOk()->assertSee('Chemka Hot Springs', false);
        $this->get('/destinations/chemka-hot-springs')->assertOk()->assertSee('Chemka Hot Springs');
    }

    public function test_add_destination_normalizes_blank_repeater_rows(): void
    {
        $this->authAdmin();

        $this->postJson(route('admin.destinations.store'), [
            'name' => 'Minimal Tour',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => 'Full day',
            'highlights' => [
                ['icon' => '', 'text' => ''],
            ],
            'gallery' => ['', ''],
            'quick_facts' => [
                ['label' => '', 'value' => ''],
            ],
        ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $dest = Destination::where('name', 'Minimal Tour')->firstOrFail();

        $this->assertNull($dest->highlights);
        $this->assertNull($dest->gallery);
        $this->assertNull($dest->quick_facts);

        $this->get('/destinations/minimal-tour')->assertOk();
    }

    public function test_build_tours_prefers_db_rich_content(): void
    {
        $dest = $this->createDestination([
            'slug' => 'db-only-tour',
            'name' => 'DB Only Tour',
            'category' => 'Day Trip',
            'duration' => 'Full day',
            'long_description' => 'DB-driven overview only.',
            'highlights' => [['icon' => 'fa-leaf', 'text' => 'DB Highlight']],
        ]);

        $tour = $this->builtTour('db-only-tour');

        $this->assertNotNull($tour);
        $this->assertSame('DB-driven overview only.', $tour['overview']);
        $this->assertSame([['icon' => 'fa-leaf', 'text' => 'DB Highlight']], $tour['highlights']);
        $this->assertSame('day-trip', $tour['category']);
        $this->assertSame($dest->id, $tour['db']['id']);
    }

    public function test_build_tours_falls_back_to_static_content_when_db_empty(): void
    {
        // First created row gets id 1, which maps to the static Materuni tour (db.id = 1).
        $this->createDestination([
            'name' => 'Master Test Row',
            'slug' => 'master-test-row',
        ]);

        $tour = $this->builtTour('master-test-row');

        $this->assertNotNull($tour);
        $this->assertStringContainsString('Materuni', $tour['overview']);
        $this->assertNotEmpty($tour['itinerary']);
        $this->assertNotEmpty($tour['faqs']);
    }

    public function test_code_only_tours_keep_null_db_and_static_content(): void
    {
        $this->createDestination(['slug' => 'unrelated-tour', 'name' => 'Unrelated']);

        $tours = SafariContent::buildTours(Destination::where('status', 'Published')->get());

        $zanzibar = collect($tours)->first(fn ($t) => $t['slug'] === 'zanzibar-escape');
        $this->assertNotNull($zanzibar);
        $this->assertNull($zanzibar['db']);
        $this->assertNotEmpty($zanzibar['itinerary']);
        $this->assertSame('beach', $zanzibar['category']);
    }

    public function test_admin_only_destinations_are_appended_to_listings(): void
    {
        // Create enough rows so at least one has an id with no static counterpart.
        for ($i = 1; $i <= 7; $i++) {
            $this->createDestination([
                'name' => "Extra Tour {$i}",
                'slug' => "extra-tour-{$i}",
            ]);
        }

        $tour = $this->builtTour('extra-tour-3');

        $this->assertNotNull($tour);
    }

    public function test_legacy_category_mapping(): void
    {
        $this->assertSame('day-trip', SafariContent::listingCategory('Day Trip'));
        $this->assertSame('safari', SafariContent::listingCategory('Multi-Day Safari'));
        $this->assertSame('kilimanjaro', SafariContent::listingCategory('kilimanjaro'));
        $this->assertSame('day-trip', SafariContent::listingCategory(''));
    }

    public function test_public_pages_render_with_merged_tours(): void
    {
        $this->createDestination([
            'name' => 'Serengeti Safari',
            'slug' => 'serengeti-safari',
        ]);

        $this->get('/')->assertOk();
        $this->get('/destinations')->assertOk();
        $this->get('/destinations/serengeti-safari')->assertOk()->assertSee('Serengeti Safari');
    }

    public function test_faq_pairs_without_question_or_answer_are_dropped_on_save(): void
    {
        $this->authAdmin();

        $this->post(route('admin.destinations.store'), [
            'name' => 'Lake Manyara Day Trip',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => '1 Day',
            'price_adult' => 150,
            'faqs' => [
                ['q' => 'Is lunch included?', 'a' => 'Yes.'],
                ['q' => 'Question without answer', 'a' => ''],
                ['q' => '', 'a' => 'Answer without question'],
                ['q' => '', 'a' => ''],
            ],
        ])->assertSessionHas('success');

        $dest = Destination::where('name', 'Lake Manyara Day Trip')->first();

        $this->assertNotNull($dest);
        $this->assertSame([['q' => 'Is lunch included?', 'a' => 'Yes.']], $dest->faqs);
    }

    public function test_orphan_faq_rows_are_never_rendered_on_public_pages(): void
    {
        $this->createDestination([
            'slug' => 'orphan-faq-tour',
            'name' => 'Orphan FAQ Tour',
            'faqs' => [
                ['q' => 'Only question', 'a' => ''],
                ['q' => '', 'a' => 'Only answer'],
                ['q' => 'Paired?', 'a' => 'Paired!'],
            ],
        ]);

        $tour = $this->builtTour('orphan-faq-tour');

        $this->assertSame([['q' => 'Paired?', 'a' => 'Paired!']], $tour['faqs']);

        $this->get('/destinations/orphan-faq-tour')
            ->assertOk()
            ->assertSee('Paired?')
            ->assertSee('Paired!')
            ->assertDontSee('Only question');
    }

    public function test_new_sparse_destination_renders_full_serengeti_format(): void
    {
        // Occupying the ids (1-6) the static content map claims for the seeded destinations,
        // mirroring production so the new tour (id 7+) is a genuine admin-only row.
        foreach ([
            ['slug' => 'materuni-waterfall-coffee-tour', 'name' => 'Materuni Waterfall & Coffee Tour'],
            ['slug' => 'chemka-hot-springs', 'name' => 'Chemka Hot Springs'],
            ['slug' => 'marangu-cultural-tour', 'name' => 'Marangu Cultural Tour'],
            ['slug' => 'kilimanjaro-day-hike', 'name' => 'Kilimanjaro Day Hike'],
            ['slug' => 'serengeti-safari', 'name' => 'Serengeti Safari'],
            ['slug' => 'ngorongoro-crater', 'name' => 'Ngorongoro Crater'],
        ] as $seed) {
            $this->createDestination($seed);
        }

        $this->createDestination([
            'slug' => 'sparse-format-tour',
            'name' => 'Sparse Format Tour',
            'long_description' => '<p><b>Rich</b> overview body.</p>',
            'quick_facts' => [['label' => 'Duration', 'value' => '1 Day']],
            'highlights' => [['icon' => 'fa-lion', 'text' => 'Big Cats']],
            'includes' => ['Park fees'],
            'excluded' => ['Tips'],
        ]);

        $this->get('/destinations/sparse-format-tour')
            ->assertOk()
            ->assertSee('<b>Rich</b> overview body.', false)
            ->assertSee('Quick Facts')
            ->assertSee('Big Cats')
            ->assertSee('Included in Your Tour')
            ->assertSee('Park fees')
            ->assertSee('Excluded from Your Tour')
            ->assertSee('Tips')
            ->assertDontSee('Detailed Itinerary');
    }
}