<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'duration', 'price', 'price_adult', 'price_child', 'status', 'image', 'desc', 'meta_title', 'meta_description', 'meta_keywords'];

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

            // Auto-generate SEO metadata if not provided
            if (empty($destination->meta_title)) {
                $destination->meta_title = self::generateMetaTitle($destination);
            }
            
            if (empty($destination->meta_description)) {
                $destination->meta_description = self::generateMetaDescription($destination);
            }
            
            if (empty($destination->meta_keywords)) {
                $destination->meta_keywords = self::generateMetaKeywords($destination);
            }
        });
    }

    /**
     * Generate SEO-friendly meta title
     */
    protected static function generateMetaTitle($destination)
    {
        $category = $destination->category ?? 'Safari';
        $name = $destination->name ?? 'Tanzania Tour';
        
        return "{$name} - {$category} | Tanzania Daily Tours & Safari";
    }

    /**
     * Generate SEO-friendly meta description
     */
    protected static function generateMetaDescription($destination)
    {
        $name = $destination->name ?? 'this Tanzania safari';
        $category = $destination->category ?? 'safari';
        $duration = $destination->duration ?? '';
        $price = $destination->price_adult ?? $destination->price ?? 0;
        
        $description = "Book {$name} with expert local guides. ";
        
        if ($duration) {
            $description .= "{$duration} {$category} experience. ";
        }
        
        $description .= "Best prices starting from \${$price}. ";
        $description .= "Experience authentic Tanzania wildlife and culture with Tanzania Daily Tours & Safari.";
        
        return Str::limit($description, 160);
    }

    /**
     * Generate SEO-friendly meta keywords
     */
    protected static function generateMetaKeywords($destination)
    {
        $name = $destination->name ?? '';
        $category = $destination->category ?? '';
        $keywords = [];
        
        // Primary keywords based on destination name
        $keywords[] = $name;
        $keywords[] = "Tanzania {$name}";
        $keywords[] = "{$name} safari";
        
        // Category-based keywords
        if ($category) {
            $keywords[] = $category;
            $keywords[] = "Tanzania {$category}";
            $keywords[] = "{$category} Tanzania";
        }
        
        // General safari keywords
        $keywords[] = "Tanzania safari";
        $keywords[] = "Tanzania tour";
        $keywords[] = "wildlife safari";
        $keywords[] = "safari packages";
        $keywords[] = "Tanzania tours";
        
        // Location keywords
        $keywords[] = "Serengeti safari";
        $keywords[] = "Ngorongoro safari";
        $keywords[] = "Kilimanjaro tours";
        $keywords[] = "Tanzania national parks";
        
        // Remove duplicates and limit
        $keywords = array_unique($keywords);
        return implode(', ', array_slice($keywords, 0, 15));
    }
}
