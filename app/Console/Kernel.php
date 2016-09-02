<?php

namespace App\Console;

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
//         Commands\Inspire::class,
//         Commands\TravelShipSender::class,
//         Commands\TravelShipCleaner::class,
//         Commands\AuctionPurchases::class,
//         Commands\Process\TimersCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')->everyMinute();
//         $schedule->command('process:timers')->everyMinute();
//         $schedule->command('travel_sender')->everyFiveMinutes();
//         $schedule->command('travel_cleaner')->everyFiveMinutes();
//         $schedule->command('auction:purchases')->everyFiveMinutes();
//
    }
}
