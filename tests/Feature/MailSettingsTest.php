<?php

namespace Tests\Feature;

use App\Mail\TestMail;
use App\Models\AdminUser;
use App\Services\MailSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailSettingsTest extends TestCase
{
    use RefreshDatabase;

    private function adminSession(): void
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

    public function test_mail_settings_can_be_saved(): void
    {
        $this->adminSession();

        $response = $this->put(route('admin.settings.mail.update'), [
            'mail_smtp_host' => 'smtp.gmail.com',
            'mail_smtp_port' => '587',
            'mail_smtp_encryption' => 'tls',
            'mail_smtp_username' => 'hello@example.com',
            'mail_smtp_password' => 'secret-app-password',
            'mail_from_name' => 'Tanzania Daily Tours',
            'mail_from_address' => 'info@tanzaniadailytoursandsafari.com',
        ]);

        $response->assertRedirect();
        $this->assertSame('smtp.gmail.com', MailSettings::value('mail_smtp_host'));
        $this->assertSame('587', MailSettings::value('mail_smtp_port'));
        $this->assertSame('secret-app-password', MailSettings::secret('mail_smtp_password'));
        $this->assertSame('info@tanzaniadailytoursandsafari.com', MailSettings::value('mail_from_address'));
        $this->assertTrue(MailSettings::configured());
    }

    public function test_blank_password_keeps_existing_secret(): void
    {
        $this->adminSession();

        MailSettings::saveSecret('mail_smtp_password', 'original-pass');

        $response = $this->put(route('admin.settings.mail.update'), [
            'mail_smtp_host' => 'smtp.example.com',
            'mail_smtp_port' => '465',
            'mail_smtp_encryption' => 'ssl',
            'mail_smtp_username' => 'hello@example.com',
            'mail_smtp_password' => '',
            'mail_from_name' => 'TDTS',
            'mail_from_address' => 'info@tanzaniadailytoursandsafari.com',
        ]);

        $response->assertRedirect();
        $this->assertSame('original-pass', MailSettings::secret('mail_smtp_password'));
    }

    public function test_test_email_sends_to_recipient(): void
    {
        $this->adminSession();
        Mail::fake();

        MailSettings::save('mail_smtp_host', 'smtp.gmail.com');
        MailSettings::save('mail_smtp_port', '587');
        MailSettings::save('mail_smtp_username', 'hello@example.com');
        MailSettings::saveSecret('mail_smtp_password', 'secret');
        MailSettings::save('mail_from_address', 'info@tanzaniadailytoursandsafari.com');

        $response = $this->post(route('admin.settings.mail.test'), [
            'to' => 'manager@example.com',
        ]);

        $response->assertRedirect();
        $this->assertSame('Test email sent to manager@example.com.', session('success'));

        Mail::assertSent(TestMail::class, function ($mail) {
            return $mail->hasTo('manager@example.com');
        });
    }
}