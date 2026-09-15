<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Support\SafariContent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('destination:export')]
#[Description('Snapshot all destination rows to storage/app as JSON (run before big migrations)')]
class DestinationExport extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $rows = Destination::orderBy('id')->get()->map(function ($d) {
            return $d->toArray();
        })->all();

        $file = storage_path('app/destinations-export-'.date('Ymd-His').'.json');
        file_put_contents($file, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info('Exported '.count($rows).' destination(s) to '.$file);

        return self::SUCCESS;
    }
}