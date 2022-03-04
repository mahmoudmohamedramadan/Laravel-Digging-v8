<?php

namespace App\Providers;

use App\{Models\User, Observers\UserObserver};
use Illuminate\Auth\{Events\Registered, Listeners\SendEmailVerificationNotification};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /* you should register the model observer to triggere some actions after we've done some updates to the model, NOTE that to create a policy while creating the model you can pass `-p` argument or as option `--policy`, you can pass `--all` option and in this case will create a new `migration`, `factory`, `seeder`, `controller`, and `policy` */
        User::observe(UserObserver::class);
    }
}
