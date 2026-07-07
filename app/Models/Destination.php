<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'duration', 'price', 'price_adult', 'price_child', 'status', 'image', 'desc'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($destination) {
            // Determine if we need to generate a new slug
            $needsNewSlug = empty($destination->slug);
            
            // If slug exists, check if name has changed
            if (!$needsNewSlug && $destination->exists) {
                $originalName = $destination->getOriginal('name');
                if ($originalName !== $destination->name) {
                    $needsNewSlug = true;
                }
            }
            
            if ($needsNewSlug) {
                $slug = Str::slug($destination->name);
                $originalSlug = $slug;
                $count = 1;
                
                // Check if slug exists (excluding current model if updating)
                while (static::where('slug', $slug)->where('id', '!=', $destination->id)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }
                
                $destination->slug = $slug;
            }
        });
    }
}
