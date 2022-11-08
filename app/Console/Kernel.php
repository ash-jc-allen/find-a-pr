<?php

namespace App\Console;

use App\Jobs\SendPing;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('repos:preload')->hourly();
        $schedule->command('repos:crawlable')->weekly();

        // Ping OhDear to make sure the scheduler and default queue is running.
        $schedule->job(new SendPing(config('services.ohdear.ping_url')))->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
