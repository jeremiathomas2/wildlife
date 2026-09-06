<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Message;
use App\Models\Review;
use App\Services\MailSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminMailController extends Controller
{
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mail_smtp_host' => 'required|string|max:255',
            'mail_smtp_port' => 'required|integer|min:1|max:65535',
            'mail_smtp_encryption' => 'required|in:none,tls,ssl',
            'mail_smtp_username' => 'required|string|max:255',
            'mail_from_name' => 'required|string|max:255',
            'mail_from_address' => 'required|email|max:255',
        ]);

        MailSettings::save('mail_smtp_host', $request->input('mail_smtp_host'));
        MailSettings::save('mail_smtp_port', (string) $request->integer('mail_smtp_port'));
        MailSettings::save('mail_smtp_encryption', $request->input('mail_smtp_encryption'));
        MailSettings::save('mail_smtp_username', $request->input('mail_smtp_username'));
        MailSettings::save('mail_from_name', $request->input('mail_from_name'));
        MailSettings::save('mail_from_address', $request->input('mail_from_address'));

        $password = trim((string) $request->input('mail_smtp_password'));
        if ($password !== '') {
            MailSettings::saveSecret('mail_smtp_password', $password);
        }

        return back()->with('success', 'Mail settings saved.');
    }

    public function sendTest(Request $request): RedirectResponse
    {
        $to = $request->input('to') ?: (string) MailSettings::value('mail_from_address', '');
        if (!$to) {
            return back()->with('error', 'No recipient address provided.');
        }
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Please provide a valid test recipient email.');
        }

        $this->applyMailConfig();

        try {
            Mail::mailer('smtp')->to($to)->send(new TestMail());
            return back()->with('success', 'Test email sent to ' . $to . '.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
    }

    protected function applyMailConfig(): void
    {
        $host = (string) MailSettings::value('mail_smtp_host', '');
        $port = (int) MailSettings::value('mail_smtp_port', 587);
        $encryption = (string) MailSettings::value('mail_smtp_encryption', 'tls');
        $username = (string) MailSettings::value('mail_smtp_username', '');
        $password = (string) MailSettings::secret('mail_smtp_password', '');
        $fromAddress = (string) MailSettings::value('mail_from_address', '');
        $fromName = (string) MailSettings::value('mail_from_name', '');

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $host,
            'mail.mailers.smtp.port' => $port,
            'mail.mailers.smtp.encryption' => $encryption === 'none' ? null : $encryption,
            'mail.mailers.smtp.username' => $username,
            'mail.mailers.smtp.password' => $password,
            'mail.from.address' => $fromAddress ?: config('mail.from.address'),
            'mail.from.name' => $fromName ?: config('mail.from.name'),
        ]);
    }
}
