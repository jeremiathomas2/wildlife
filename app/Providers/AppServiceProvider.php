<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\CurrentAdminUserComposer;
use App\Http\ViewComposers\PaymentCountComposer;
use App\Services\MailSettings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.*', CurrentAdminUserComposer::class);
        View::composer('admin.layout', PaymentCountComposer::class);

        try {
            $this->applyDynamicMailConfig();
        } catch (\Throwable $e) {
            // Database may not be migrated yet (e.g. tests, fresh installs, artisan commands).
        }
    }

    protected function applyDynamicMailConfig(): void
    {
        if (!MailSettings::configured()) {
            return;
        }

        $cfg = MailSettings::config();
        $encryption = $cfg['encryption'] === 'none' ? null : $cfg['encryption'];

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $cfg['host'],
            'mail.mailers.smtp.port' => $cfg['port'],
            'mail.mailers.smtp.encryption' => $encryption,
            'mail.mailers.smtp.username' => $cfg['username'],
            'mail.mailers.smtp.password' => $cfg['password'],
            'mail.from.address' => $cfg['from']['address'],
            'mail.from.name' => $cfg['from']['name'],
        ]);
    }
}
