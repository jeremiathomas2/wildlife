<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
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

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'tour_name', 'name');
    }
}
