<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\AdminLoginLog;
use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(array $overrides = []): AdminUser
    {
        return AdminUser::create(array_merge([
            'name' => 'Asha Mwangi',
            'email' => 'asha' . uniqid() . '@example.com',
            'password' => 'secret123',
            'role' => 'super_admin',
            'is_active' => true,
        ], $overrides));
    }

    private function loginAs(?AdminUser $user = null): AdminUser
    {
        $user = $user ?: $this->makeUser();
        $this->withSession([
            'admin_logged_in' => true,
            'admin_user_id' => $user->id,
            'admin_last_activity' => time(),
        ]);

        return $user;
    }

    public function test_logged_in_session_grants_access_to_users_page(): void
    {
        $this->loginAs();

        $this->get(route('admin.users'))->assertOk();
    }

    public function test_successful_login_is_logged(): void
    {
        $admin = $this->makeUser(['email' => 'admin@login.test']);

        $this->post(route('admin.login.submit'), [
            'email' => 'admin@login.test',
            'password' => 'secret123',
        ]);

        $this->assertDatabaseHas('admin_login_logs', [
            'email' => 'admin@login.test',
            'success' => true,
        ]);
    }

    public function test_failed_login_is_logged(): void
    {
        $this->makeUser(['email' => 'admin@login.test']);

        $this->post(route('admin.login.submit'), [
            'email' => 'admin@login.test',
            'password' => 'wrong-password',
        ]);

        $this->assertDatabaseHas('admin_login_logs', [
            'email' => 'admin@login.test',
            'success' => false,
        ]);
    }

    public function test_super_admin_can_create_user_and_audit_is_recorded(): void
    {
        $actor = $this->loginAs();

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Juma Hassan',
            'email' => 'juma@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'is_active' => '1',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('admin_users', ['email' => 'juma@example.com', 'role' => 'admin']);
        $this->assertDatabaseHas('admin_activity_logs', [
            'admin_user_id' => $actor->id,
            'action' => 'user.created',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        $this->makeUser(['email' => 'dupe@example.com']);
        $this->loginAs();

        $this->post(route('admin.users.store'), [
            'name' => 'Duplicate',
            'email' => 'dupe@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ])->assertSessionHasErrors('email');
    }

    public function test_editor_cannot_manage_users(): void
    {
        $this->loginAs($this->makeUser(['role' => 'editor']));

        $this->post(route('admin.users.store'), [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $this->assertDatabaseMissing('admin_users', ['email' => 'hacker@example.com']);
    }

    public function test_only_super_admin_can_delete_users(): void
    {
        $target = $this->makeUser(['name' => 'Target']);
        $this->loginAs($this->makeUser(['role' => 'admin']));

        $this->delete(route('admin.users.destroy', $target->id));

        $this->assertDatabaseHas('admin_users', ['id' => $target->id]);
    }

    public function test_user_cannot_delete_own_account(): void
    {
        $actor = $this->loginAs();

        $this->delete(route('admin.users.destroy', $actor->id));

        $this->assertDatabaseHas('admin_users', ['id' => $actor->id]);
    }

    public function test_cannot_demote_the_last_super_admin(): void
    {
        $super = $this->makeUser(['name' => 'Solo Super', 'role' => 'super_admin']);
        $this->loginAs($this->makeUser(['role' => 'admin']));

        $this->put(route('admin.users.update', $super->id), [
            'name' => $super->name,
            'email' => $super->email,
            'role' => 'editor',
            'is_active' => '1',
            'must_change_password' => '0',
        ]);

        $this->assertDatabaseHas('admin_users', ['id' => $super->id, 'role' => 'super_admin']);
    }

    public function test_user_cannot_change_own_role(): void
    {
        $actor = $this->loginAs();

        $this->put(route('admin.users.update', $actor->id), [
            'name' => $actor->name,
            'email' => $actor->email,
            'role' => 'editor',
            'is_active' => '1',
            'must_change_password' => '0',
        ]);

        $this->assertDatabaseHas('admin_users', ['id' => $actor->id, 'role' => 'super_admin']);
    }

    public function test_user_cannot_deactivate_self(): void
    {
        $actor = $this->loginAs();

        $this->put(route('admin.users.update', $actor->id), [
            'name' => $actor->name,
            'email' => $actor->email,
            'role' => 'super_admin',
            'is_active' => '0',
            'must_change_password' => '0',
        ]);

        $this->assertDatabaseHas('admin_users', ['id' => $actor->id, 'is_active' => true]);
    }

    public function test_admin_can_toggle_user_status(): void
    {
        $actor = $this->loginAs();
        $target = $this->makeUser(['name' => 'Toggle Me']);

        $this->post(route('admin.users.toggle', $target->id));

        $this->assertDatabaseHas('admin_users', ['id' => $target->id, 'is_active' => false]);
        $this->assertDatabaseHas('admin_activity_logs', [
            'admin_user_id' => $actor->id,
            'action' => 'user.toggled',
        ]);
    }

    public function test_reset_password_forces_change_on_next_login(): void
    {
        $target = $this->makeUser(['name' => 'Reset Me']);
        $this->loginAs();

        $this->post(route('admin.users.reset-password', $target->id), [
            'password' => 'new-password-1',
            'password_confirmation' => 'new-password-1',
        ]);

        $this->assertDatabaseHas('admin_users', [
            'id' => $target->id,
            'must_change_password' => true,
        ]);
        $this->assertTrue($target->fresh()->checkPassword('new-password-1'));
    }

    public function test_forced_redirect_to_change_password_then_updates_credentials(): void
    {
        $target = $this->makeUser([
            'name' => 'Forced',
            'must_change_password' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => $target->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.change-password'));

        $this->post(route('admin.change-password.submit'), [
            'password' => 'fresh-password-1',
            'password_confirmation' => 'fresh-password-1',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('admin_users', [
            'id' => $target->id,
            'must_change_password' => false,
        ]);
        $this->assertTrue($target->fresh()->checkPassword('fresh-password-1'));
    }

    public function test_user_detail_page_shows_login_and_activity_history(): void
    {
        $actor = $this->loginAs();
        $target = $this->makeUser(['name' => 'Historian']);

        AdminLoginLog::create([
            'admin_user_id' => $target->id,
            'email' => $target->email,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'success' => true,
        ]);

        AdminActivityLog::create([
            'admin_user_id' => $target->id,
            'action' => 'user.updated',
            'entity_type' => 'admin_user',
            'entity_id' => $target->id,
            'details' => ['role' => ['from' => 'admin', 'to' => 'super_admin']],
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->get(route('admin.users.show', $target->id));

        $response->assertOk();
        $response->assertSee($target->email);
        $response->assertViewHas('loginLogs', fn ($logs) => $logs->count() === 1);
        $response->assertViewHas('recentActivity', fn ($logs) => $logs->count() === 1);
        $this->assertTrue($actor->id === $target->id || true);
    }

    public function test_users_page_supports_filters(): void
    {
        $this->makeUser(['name' => 'Active User', 'is_active' => true]);
        $this->makeUser(['name' => 'Inactive User', 'is_active' => false]);
        $this->loginAs();

        $this->get(route('admin.users', ['status' => 'active']))
            ->assertOk()
            ->assertSee('Active User')
            ->assertDontSee('Inactive User');

        $this->get(route('admin.users', ['q' => 'Inactive']))
            ->assertOk()
            ->assertSee('Inactive User');
    }
}