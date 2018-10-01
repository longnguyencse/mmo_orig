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
        //
        'App\Console\Commands\testView',
        'App\Console\Commands\autoupload',
        'App\Console\Commands\autoreup',
        'App\Console\Commands\autoreup1',
        'App\Console\Commands\autoreup2',
        'App\Console\Commands\autoreup3',
        'App\Console\Commands\autoreup4',
        'App\Console\Commands\autoreup5',
        'App\Console\Commands\autoaddvideoreup',
        'App\Console\Commands\autoaddvideo',
        'App\Console\Commands\autosua',
        'App\Console\Commands\autostatus',
        'App\Console\Commands\autoxoaloi',
        'App\Console\Commands\fixloi'        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('test:view')->hourly();
        $schedule->command('auto:addvideo')->hourly();
        $schedule->command('auto:reup')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:reup1')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:reup2')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:reup3')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:reup4')->withoutOverlapping()->everyMinute();
        //$schedule->command('auto:reup5')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:status')->withoutOverlapping()->everyMinute();
        $schedule->command('auto:sua')->withoutOverlapping()->everyMinute();                
        $schedule->command('auto:addvideoreup')->everyTenMinutes();
        $schedule->command('auto:xoaloi')->everyTenMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
