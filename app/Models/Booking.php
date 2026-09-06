<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'destination_id',
        'tour_name',
        'base_price',
        'currency',
        'travel_date',
        'adults',
        'children',
        'email',
        'country_code',
        'phone_number',
        'total_price',
        'name',
        'guests',
        'amount',
        'status',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function getHasPaymentAttribute(): bool
    {
        return $this->payments()->exists();
    }

    public function getReferenceAttribute(): string
    {
        return 'TDTS-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
