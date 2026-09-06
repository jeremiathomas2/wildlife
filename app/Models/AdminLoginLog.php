<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLoginLog extends Model
{
    protected $fillable = [
        'admin_user_id',
        'email',
        'ip_address',
        'user_agent',
        'success',
    ];

    protected $casts = [
        'success' => 'boolean',
    ];

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
}