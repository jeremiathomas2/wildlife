<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:generate-destination-slugs')]
#[Description('Generate slugs for all destinations without them')]
class GenerateDestinationSlugs extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destinations = Destination::whereNull('slug')->orWhere('slug', '')->get();
        
        $this->info('Found ' . $destinations->count() . ' destinations without slugs.');
        
        foreach ($destinations as $destination) {
            $this->info('Processing: ' . $destination->name);
            
            $slug = Str::slug($destination->name);
            $originalSlug = $slug;
            $count = 1;
            
            // Check if slug exists (excluding current destination)
            while (Destination::where('slug', $slug)->where('id', '!=', $destination->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            
            $destination->slug = $slug;
            $destination->save();
            
            $this->info('Set slug: ' . $slug);
        }
        
        $this->info('All done!');
    }
}
