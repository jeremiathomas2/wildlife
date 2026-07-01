<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = ['name', 'category', 'duration', 'price', 'price_adult', 'price_child', 'status', 'image', 'desc'];
}
