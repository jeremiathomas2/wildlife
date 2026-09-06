<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Request;

class AdminAudit
{
    public static function log(
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        array $details = [],
        ?AdminUser $actor = null
    ): void {
        AdminActivityLog::create([
            'admin_user_id' => $actor?->id,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details ?: null,
            'ip_address' => Request::ip(),
            'user_agent' => static::userAgent(),
        ]);
    }

    public static function actor(): ?AdminUser
    {
        return session('admin_user_id')
            ? AdminUser::find(session('admin_user_id'))
            : null;
    }

    protected static function userAgent(): ?string
    {
        $ua = (string) Request::userAgent();

        return $ua === '' ? null : substr($ua, 0, 500);
    }
}