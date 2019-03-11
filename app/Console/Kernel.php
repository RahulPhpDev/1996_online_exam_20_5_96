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
       'App\Console\Commands\RegisteredUsers',
       'App\Console\Commands\ExamAttempt',
       'App\Console\Commands\ExamAlert',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('registered:users')
        
                 ->everyMinute();
        $schedule->command('examattempt:users')
                 ->everyMinute();

        $schedule->command('alert:exam')
                 ->everyMinute();
    }

    // /usr/local/bin/php -q /home/ofdgxkwnaxeq/public_html/php artisan alert:exam >> /dev/null 2>&1 

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
