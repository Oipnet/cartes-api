<?php

namespace App\Console;

use App\Console\Commands\ListDelcampeAuctions;
use App\Console\Commands\ListDelcampeCategories;
use App\Console\Commands\ListDelcampeFixedPrice;
use App\Console\Commands\ListDelcampeNotificationConfiguration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ListDelcampeAuctions::class,
        ListDelcampeFixedPrice::class,
        ListDelcampeNotificationConfiguration::class,
        ListDelcampeCategories::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ListDelcampeAuctions::class)->hourlyAt(5);
        $schedule->command(ListDelcampeFixedPrice::class)->hourlyAt(10);
        $schedule->command(ListDelcampeNotificationConfiguration::class)->dailyAt(0);
        /*$schedule->command(ListDelcampeAuctions::class)->everyMinute();
        $schedule->command(ListDelcampeFixedPrice::class)->everyMinute();*/
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
