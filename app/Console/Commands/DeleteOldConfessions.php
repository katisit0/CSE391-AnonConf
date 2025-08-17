<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOldConfessions
{
    /**
     * Define the application's command schedule.
     */
    public function __invoke(Schedule $schedule): void
    {
        // Schedule this to run every hour
        $schedule->call(function () {

            Log::info("DeleteOldConfessions task is running.");


            DB::table('confessions')
                ->where('created_at', '<', Carbon::now()->subDay())
                ->delete();
        })->hourly();
    }
}
