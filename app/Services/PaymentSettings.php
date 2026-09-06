<?php

namespace App\Services;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentSettings
{
    const GROUP = 'payment';

    const KEYS = [
        'payment_enabled' => '0',
        'pesapal_environment' => 'sandbox',
        'pesapal_consumer_key' => '',
        'pesapal_consumer_secret' => '',
        'pesapal_currency' => 'USD',
        'pesapal_deposit_percentage' => '30',
        'pesapal_notification_id' => '',
        'pesapal_ipn_url' => '',
        'pesapal_callback_url' => '',
        'pesapal_cancellation_url' => '',
    ];

    public static function value(string $key, $default = null)
    {
        $row = SiteContent::where('key', $key)->first();
        if (!$row || $row->value === null || $row->value === '') {
            return $default;
        }
        return $row->value;
    }

    public static function save(string $key, ?string $value): void
    {
        SiteContent::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value ?? '',
                'type' => 'text',
                'group' => self::GROUP,
                'label' => ucwords(str_replace('_', ' ', $key)),
            ]
        );
    }

    public static function secret(string $key, $default = null): ?string
    {
        $row = SiteContent::where('key', $key)->first();
        if (!$row || $row->value === null || $row->value === '') {
            return $default;
        }
        try {
            return Crypt::decryptString($row->value);
        } catch (DecryptException $e) {
            // Fall back to the raw value when it was never encrypted.
            return $row->value;
        }
    }

    public static function saveSecret(string $key, string $value): void
    {
        self::save($key, Crypt::encryptString($value));
    }

    public static function isStored(string $key): bool
    {
        $row = SiteContent::where('key', $key)->first();
        return $row && $row->value !== null && $row->value !== '';
    }

    public static function environment(): string
    {
        return self::value('pesapal_environment', 'sandbox') === 'live' ? 'live' : 'sandbox';
    }

    public static function isEnabled(): bool
    {
        return in_array(self::value('payment_enabled', '0'), ['1', 'true', 'on'], true);
    }

    public static function currency(): string
    {
        return strtoupper(self::value('pesapal_currency', 'USD') ?: 'USD');
    }

    public static function depositPercentage(): int
    {
        return max(0, min(100, (int) self::value('pesapal_deposit_percentage', 0)));
    }

    public static function notificationId(): string
    {
        return (string) self::value('pesapal_notification_id', '');
    }

    public static function toArray(): array
    {
        $out = [];
        foreach (self::KEYS as $key => $default) {
            $out[$key] = self::value($key, $default);
        }
        return $out;
    }
}