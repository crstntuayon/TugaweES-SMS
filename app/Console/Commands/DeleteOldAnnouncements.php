<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Announcement;
use Carbon\Carbon;

class DeleteOldAnnouncements extends Command
{
    protected $signature = 'announcements:delete-old';
    protected $description = 'Soft delete announcements older than 1 week';

    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        Announcement::where('created_at', '<', $oneWeekAgo)->delete(); // <-- your line here
        $this->info('Old announcements deleted.');
    }
}
