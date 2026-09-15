<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentTest extends TestCase
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

    public function test_guests_are_redirected_from_content_page(): void
    {
        $this->get(route('admin.content'))->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_can_view_content_page(): void
    {
        SiteContent::updateOrCreate(
            ['key' => 'home_hero_title'],
            ['label' => 'Hero Title', 'type' => 'text', 'group' => 'home', 'value' => 'Experience the Wild']
        );
        $this->authAdmin();

        $this->get(route('admin.content'))
            ->assertOk()
            ->assertSee('Site Content')
            ->assertSee('Hero Title');
    }

    public function test_content_update_upserts_values_and_creates_missing_rows(): void
    {
        SiteContent::updateOrCreate(
            ['key' => 'home_hero_title'],
            ['label' => 'Hero Title', 'type' => 'text', 'group' => 'home', 'value' => 'Old Hero']
        );
        $this->authAdmin();

        $this->put(route('admin.content.update'), [
            'content' => [
                'home_hero_title' => 'New Hero',
                'brand_new_key' => 'New Value',
            ],
        ])->assertSessionHas('success');

        $this->assertSame('New Hero', SiteContent::where('key', 'home_hero_title')->value('value'));
        $this->assertSame('New Value', SiteContent::where('key', 'brand_new_key')->value('value'));
    }
}
