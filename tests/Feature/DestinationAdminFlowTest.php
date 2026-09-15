<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestinationAdminFlowTest extends TestCase
{
    use RefreshDatabase;

    private function loginAdmin(): void
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
    }

    public function test_browser_like_add_destination_returns_json_success(): void
    {
        $this->loginAdmin();

        $response = $this->post('/live/destinations', [
            'name' => 'Browser Add Tour',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => 'Full day',
            'price_adult' => 90,
            'price_child' => 45,
            'image' => 'https://example.com/cover.jpg',
            'desc' => 'A new tour',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-CSRF-TOKEN' => csrf_token(),
            'Accept' => '*/*',
        ]);

        $response->assertStatus(200);
        $json = $response->json();
        $this->assertTrue($json['success'] ?? false);
        $this->assertSame('Browser Add Tour', $json['destination']['name'] ?? null);
        $this->assertSame(1, Destination::where('name', 'Browser Add Tour')->count());

        $this->get('/')->assertSee('Browser Add Tour');
        $this->get('/destinations/browser-add-tour')->assertStatus(200)->assertSee('Browser Add Tour');
    }

    public function test_add_destination_redirects_to_login_when_admin_session_missing(): void
    {
        $response = $this->post('/live/destinations', [
            'name' => 'No Session Tour',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => 'Full day',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-CSRF-TOKEN' => csrf_token(),
            'Accept' => '*/*',
        ]);

        $response->assertRedirect(route('admin.login'));
        $this->assertSame(0, Destination::where('name', 'No Session Tour')->count());
    }

    public function test_destinations_list_renders_view_and_modal_edit_actions(): void
    {
        $this->loginAdmin();
        $dest = Destination::create([
            'name' => 'Harbor View Tour',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => '3 hours',
            'price_adult' => 100,
            'price_child' => 50,
            'image' => 'https://example.com/harbor.jpg',
            'desc' => 'A boat tour of the harbor.',
            'slug' => 'harbor-view-tour',
        ]);

        $response = $this->get(route('admin.destinations'));
        $response->assertStatus(200);
        $response->assertSee('/destinations/harbor-view-tour', false);
        $response->assertSee('openDestinationModal('.$dest->id.')', false);
        $response->assertSee('confirmDeleteDest('.$dest->id.', ', false);
    }

    public function test_browser_like_modal_edit_returns_json_success(): void
    {
        $this->loginAdmin();
        $dest = Destination::create([
            'name' => 'Harbor View Tour',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => '3 hours',
            'price_adult' => 100,
            'price_child' => 50,
            'image' => 'https://example.com/harbor.jpg',
            'slug' => 'harbor-view-tour',
        ]);

        $response = $this->call('POST', '/live/destinations/'.$dest->id, [
            '_method' => 'PUT',
            'name' => 'Harbor View Edited',
            'category' => 'Day Trip',
            'status' => 'Published',
            'duration' => '3 hours',
            'price_adult' => 120,
            'highlights' => [['icon' => 'fa-water', 'text' => 'Harbor boat tour']],
            'includes' => ['Boat ride', 'Guide'],
        ], [], [], [
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
            'HTTP_ACCEPT' => '*/*',
            'HTTP_X_CSRF_TOKEN' => csrf_token(),
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response->json()['success']);
        $dest->refresh();
        $this->assertSame('Harbor View Edited', $dest->name);
        $this->assertSame(120.0, (float) $dest->price_adult);
        $this->assertSame(['Boat ride', 'Guide'], $dest->includes);
        $this->assertSame('fa-water', $dest->highlights[0]['icon']);
    }
}