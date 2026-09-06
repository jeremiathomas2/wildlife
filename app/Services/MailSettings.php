<?php

namespace App\Services;

use App\Models\SiteContent;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MailSettings
{
    const GROUP = 'mail';

    const KEYS = [
        'mail_smtp_host' => '',
        'mail_smtp_port' => '587',
        'mail_smtp_encryption' => 'tls',
        'mail_smtp_username' => '',
        'mail_smtp_password' => '',
        'mail_from_name' => 'Tanzania Daily Tours & Safari',
        'mail_from_address' => 'info@tanzaniadailytoursandsafari.com',
    ];

    const SECRET_KEYS = [
        'mail_smtp_password',
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

    public static function toArray(): array
    {
        $out = [];
        foreach (self::KEYS as $key => $default) {
            $out[$key] = in_array($key, self::SECRET_KEYS, true)
                ? self::secret($key, $default)
                : self::value($key, $default);
        }
        return $out;
    }

    public static function config(): array
    {
        return [
            'host' => (string) self::value('mail_smtp_host', ''),
            'port' => (int) self::value('mail_smtp_port', 587),
            'encryption' => (string) self::value('mail_smtp_encryption', 'tls') ?: null,
            'username' => (string) self::value('mail_smtp_username', ''),
            'password' => self::secret('mail_smtp_password', ''),
            'from' => [
                'address' => (string) self::value('mail_from_address', 'info@tanzaniadailytoursandsafari.com'),
                'name' => (string) self::value('mail_from_name', 'Tanzania Daily Tours & Safari'),
            ],
        ];
    }

    public static function configured(): bool
    {
        return in_array(self::value('mail_smtp_password'), ['', null], true) === false
            && (string) self::value('mail_smtp_username', '') !== '';
    }
}
