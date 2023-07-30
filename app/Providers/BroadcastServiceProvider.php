<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | When starting use broadcasting you may need to use `Pusher`, and you'll find two categories in Push dashboard
        | Channel: used specifically in real-time communication between servers, apps and devices.
        | Beams: used specifically in push notification to iOS, Android and Web applications.
        |--------------------------------------------------------------------------
        */

        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
