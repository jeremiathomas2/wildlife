<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_EXPIRED = 'expired';

    const MODE_FULL = 'full';
    const MODE_DEPOSIT = 'deposit';

    protected $fillable = [
        'booking_id',
        'merchant_reference',
        'order_tracking_id',
        'redirect_url',
        'payment_mode',
        'deposit_percentage',
        'amount',
        'requested_amount',
        'currency',
        'status',
        'provider',
        'payment_method',
        'description',
        'customer_name',
        'customer_email',
        'customer_phone',
        'billing_address',
        'callback_data',
        'ipn_data',
        'raw_request',
        'raw_response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'requested_amount' => 'decimal:2',
        'billing_address' => 'array',
        'callback_data' => 'array',
        'ipn_data' => 'array',
        'raw_request' => 'array',
        'raw_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getIsPendingAttribute(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    public function getHumanReferenceAttribute(): string
    {
        return str_replace('TDTS-', 'REF-', strtoupper($this->merchant_reference));
    }

    public static function statusTag(string $status): string
    {
        $map = [
            self::STATUS_PENDING => 'tag-gold',
            self::STATUS_PROCESSING => 'tag-gold',
            self::STATUS_COMPLETED => 'tag-green',
            self::STATUS_FAILED => 'tag-red',
            self::STATUS_CANCELLED => 'tag-grey',
            self::STATUS_REFUNDED => 'tag-grey',
            self::STATUS_EXPIRED => 'tag-grey',
        ];
        $class = $map[$status] ?? 'tag-grey';
        return '<span class="tag ' . $class . '">' . htmlspecialchars(ucfirst($status)) . '</span>';
    }
}