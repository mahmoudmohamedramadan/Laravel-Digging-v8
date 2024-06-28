<?php

namespace App\Console;

use App\Jobs\UserReports;
use Illuminate\{Console\Scheduling\Schedule, Foundation\Console\Kernel as ConsoleKernel};

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
        /* You can use `model:prune` or `model:prun`, for more info: https://github.com/laravel/framework/discussions/38900 */
        $schedule->command('model:prune', [
            '--model' => [\App\Models\Dog::class],
        ])->everyMinute();

        $schedule->command('inspire')->everyTwoMinutes();

        $schedule->call(function () {
            UserReports::dispatch();
        })->everyMinute();

        // The lower line is equivalent to the upper line
        $schedule->job(UserReports::class)->everyMinute();

        // You can run any shell commands that you could run with PHP `exec` method
        $schedule->exec('/bin/build.sh')->everyMinute();

        // Note: `0` refers to sunday
        $schedule->call(function () {
            // do something here...
        })->weeklyOn(0, '20:50');

        $schedule->call(function () {
            // do something here...
        })->weekly()->sundays()->at('20:50');

        // Run once per hour, weekdays, 8am-5pm
        $schedule->command('do:thing')->weekdays()->hourly()->when(function () {
            return date('H') >= 8 && date("H") <= 17;
        });

        // Run every 30 minutes except when directed not to by the `SkipDetector`
        $schedule->command('do:thing')->everyThirtyMinutes()->skip(function () {
            return app('SkipDetector')->shouldSkip();
        });

        // You can define the timezone on a specific scheduled command, using the `timezone` method
        $schedule->command('do:thing')->weeklyOn(0, '23:50')->timezone('America/Chicago');

        /* If you want to avoid your tasks overlapping each other, use the `withoutOverLapping` method to skip the task if the previous instance is still running */
        $schedule->command('do:thing')->everyMinute()->withoutOverlapping();

        /* Sometimes the output from your scheduled task is important, whether for logging, notifications, or just ensuring that the task ran */
        $schedule->command('do:thing')->daily()->sendOutputTo('folder/filePATH');

        // If you want to append it to a file instead, use the `appendOutputTo`
        $schedule->command('do:thing')->daily()->appendOutputTo('folder/filePATH');

        /* If you want to email the output to a designated recipient, write it to a file first and then add `emailOutputTo` */
        $schedule->command('test:one')
            ->daily()
            ->sendOutputTo('folder/filePATH')
            ->emailOutputTo('test@laravel.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    // You can set a default timezone using the `scheduleTimezone` method
    protected function scheduleTimezone()
    {
        return 'America/Chicago';
    }
}
