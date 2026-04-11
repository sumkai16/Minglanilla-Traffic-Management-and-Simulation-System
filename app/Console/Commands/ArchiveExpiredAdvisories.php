<?php

namespace App\Console\Commands;

use App\Models\TrafficAdvisory;
use Illuminate\Console\Command;

class ArchiveExpiredAdvisories extends Command
{
    protected $signature = 'advisories:archive-expired';
    protected $description = 'Archive all published advisories past their expiry date';

    public function handle(): void
    {
        $count = TrafficAdvisory::where('status', 'published')
            ->where('expires_at', '<', now())
            ->whereNotNull('expires_at')
            ->update(['status' => 'archived']);

        $this->info("Archived {$count} expired advisory/advisories.");
    }
}