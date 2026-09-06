<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Model
{
    public const ROLES = ['super_admin', 'admin', 'editor', 'viewer'];

    public const ROLE_LABELS = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'editor' => 'Editor',
        'viewer' => 'Viewer',
    ];

    public const ROLE_TAGS = [
        'super_admin' => 'tag-terracotta',
        'admin' => 'tag-green',
        'editor' => 'tag-gold',
        'viewer' => 'tag-grey',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'must_change_password',
        'password_changed_at',
        'last_login_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'must_change_password' => 'boolean',
        'last_login_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function loginLogs()
    {
        return $this->hasMany(AdminLoginLog::class)->orderByDesc('created_at');
    }

    public function activityLogs()
    {
        return $this->hasMany(AdminActivityLog::class)->orderByDesc('created_at');
    }

    public function roleLabel(): string
    {
        return static::ROLE_LABELS[$this->role] ?? ucwords(str_replace('_', ' ', $this->role));
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function canManageUsers(): bool
    {
        return in_array($this->role, ['super_admin', 'admin'], true);
    }

    public function canDeleteUsers(): bool
    {
        return $this->isSuperAdmin();
    }
}