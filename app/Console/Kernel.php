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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        $schedule->call('App\Jobs\SendEmailAutomatic@handle')->everyMinute()->description('SendEmailAutomatic -> everyMinute')->runInBackground();
        $schedule->call('App\Jobs\SpkDone@handle')->hourly()->description('SpkDone -> hourly')->runInBackground();
        $schedule->call('App\Jobs\ServiceDueDate@handle')->dailyAt('08:00')->description('ServiceDueDate -> dailyAt 08:00')->runInBackground();
        // $schedule->call('App\Jobs\ServiceDueDate@handle')->everyMinute()->description('ServiceDueDate -> dailyAt 08:00')->runInBackground();

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
