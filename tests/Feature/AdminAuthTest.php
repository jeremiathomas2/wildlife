<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AdminUser;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): AdminUser
    {
        return AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);
    }

    public function test_successful_login_sets_session(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertSessionHas('admin_logged_in', true);
        $this->assertSessionHas('admin_user_id', $admin->id);
    }

    public function test_invalid_credentials_redirects_back(): void
    {
        $this->createAdmin();

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $this->assertSessionMissing('admin_logged_in');
    }

    public function test_throttle_lockout_after_failed_attempts(): void
    {
        $this->createAdmin();

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), [
                'email' => 'admin@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
    }
}
