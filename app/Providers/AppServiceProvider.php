<?php

namespace App\Providers;

use App\{Student, LocalClient, Macros\StrMacroable};
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\{ServiceProvider, Facades\View};
use Illuminate\Support\{Str, Facades\DB, Facades\Blade, Facades\Queue, Facades\Storage, Facades\Response};
use Illuminate\{Pagination\Paginator, Filesystem\Filesystem, Queue\Events\JobFailed, Validation\Rules\Password};

class AppServiceProvider extends ServiceProvider
{
    /* After all providers have been registered, they are “booted”. This will fire the `boot` method on each provider. A common mistake when using service providers is attempting to use the services provided by another provider in the register method. Since, within the register method, we have no gurantee all other providers have been loaded, the service you are trying to use may not be available yet. So, service provider code that uses other services should always live in the boot method. The register method should only be used for, you guessed it, registering services with the container. Within the boot method, you may do whatever you like: register event listeners, include a routes file, register filters, or anything else you can imagine.”

    So the register one is just for binding. The boot one is to actually trigger something to happen. */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* here we bind the text that returned from the `StudentFacade` with this closure which means every time I ask for the `student` key it will return a new instance from the `Student` class */
        $this->app->bind('student', function () {
            return new Student;
        });

        /* the difference between `singleton` and `bind` is that `bind` every time I ask for something it will return a new instance, but with `singleton` it gives me one instance every time I asked for an instance */
        // $this->app->singleton('student', function() {
        //     return new Student;
        // });

        /* in case you want to edit any template of any file that Laravel create you can run >> `php artisan stub:publish` then you can edit any template and when you try to create a file from that file type you will NOTICE the changes that you made */

        /* By default, Laravel will use the fully qualified class name to store the "type" of the related model. For instance, in the `one-to-many` relationship where a `Comment` model may belong to a `Post`, the default `commentable_type` would be either `App\Models\Post`, respectively. However, you may wish to decouple these values from your application's internal structure */
        // Relation::enforceMorphMap([
        //     'post' => 'App\Models\Post',
        // ]);
    }

    /* if your service provider is only going to register binding in the container, but not perform any other bootstrapping, you can `defer` its registration, which means they won't run unless one of their binding is explicitly requested from the container, This can speed up your application's average time to bootstrap

    if you want to defer your service provider's registerations first implement the `Illuminate\Contracts\Support\DeferrableProvider` interface */

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* In Laravel, you can actually prevent lazy loading. This feature is incredibly useful because it can help you to ensure that the relationships are eager loaded. As a result of this, it can improve performance and reduce the number of queries that are made to the database. It's super simple to prevent lazy loading. All we need to do is add the */
        // User::preventsLazyLoading();

        /* Share method used to share value with key to all views which you have and to use it */
        // View::share('users', User::get());

        /* Composer method do what share method do but composer you specify the view whcih you want to share this value */
        // View::composer('home', function ($view) {
        //     $view->with('users', User::get());
        // });

        // You can also use a class instead of a closure
        // View::composer('home', UserComposer::class);

        /* The difference between `creators` are very similar to view `composers`; however, they are executed immediately after the view is instantiated instead of waiting until the view is about to render */
        // View::creator('home', function($view) {
        //     return $view->share('users', User::get());
        // });

        // You can use a class instead of a closure
        // View::composer('home', UserCreator::class);

        // Blade::component('book-component', 'modal');

        /* You can create your custom directive using `Illuminate\Support\Facades\Blade` and specially you can create your `if` directive as lower example shows as you say: `@if(auth()->guest())` NOTE when you create your custom directive you must use end{yourDirectiveName} like `endifGuest' to close your custom directive */
        Blade::if('ifGuest', function () {
            return auth()->guest();
        });

        // You can pass anything for that directive
        Blade::directive('welcomeUser', function ($welcomeString) {
            return $welcomeString;
        });

        // \App\Models\User::creating(function() {
        //     dump('user is creating now...');
        // });

        // \App\Models\User::created(function() {
        //     dump('user is created successfully');
        // });

        // In general view you can do it >> Modelname::eventName()
        // \App\Models\User::saved(function($user) {});
        // \App\Models\User::saving(function($user) {});
        // \App\Models\User::updated(function($user) {});
        // \App\Models\User::updating(function($user) {});
        // \App\Models\User::deleted(function($user) {});
        // \App\Models\User::deleting(function($user) {});

        /* `restoring` and `restored` methods are familier with `softDeletes` and when you try to restore deleted row these methods will be triggered */
        // \App\Models\User::restoring(function ($user) {
        //     dump('user is restoring now after SoftDeletes');
        // });

        // \App\Models\User::restored(function ($user) {
        //     dump('user is restored successfully');
        // });

        // when you retrieved eloquent instance this function will be triggered
        // \App\Models\User::retrieved(function ($user) {
        //     dump($user);
        // });

        /* Here you can create your custom reponse using macros, NOTE: we actually does not have `customJSON` but whenever you call `customJSON` this closure will be triggered */
        Response::macro('customJSON', function ($users) {
            return response(json_encode($users))->withHeaders(['Content-Type' => 'application/json']);
        });

        // Here we will use the `mixin` feature in the `Macroable` trait
        Str::macro('customSplit', function ($str) {
            return 'ABC-' . substr($str, 0, 3) . '-' . substr($str, 3);
        });

        /* Assume that we need lots of custom methods, if we append all of them here it will be so complicated so, here we'll need to use the `mixin` */
        // Str::macro('customSplitOne', function($str) {
        //     return 'ABC-One-' .substr($str, 0, 3) . '-'. substr($str, 3);
        // });

        Str::mixin(new StrMacroable);

        /* If you want to add an additional Flysystem provider, you'll need to `extends` Laravel's native storage system */
        Storage::extend('local', function ($app, $config) {
            return new Filesystem(new LocalClient);
        });

        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->exception
        });

        /* With a new laravel version comes and support `Tailwind-CSS` in UI so if you want to specify that you want to use `Bootstrap` write the below line */
        Paginator::useBootstrap();

        /* If you want to override the pagination view do like so */
        // Paginator::defaultView('view-name');
        // Paginator::defaultSimpleView('view-name');

        /* If you would like to specify a closure that is invoked for each SQL query executed by your application, you may use the `DB` facade's `listen` method */
        DB::listen(function ($query) {
            // $query->sql;
            // $query->bindings;
            // $query->time;
        });

        /* You may find it convenient to specify the default validation rules for passwords in a single location of your application. You can easily accomplish this using the `defaults` method */
        Password::defaults(function () {
            /* In addition, you may ensure that a password has not been compromised in a public password data breach leak using the `uncompromised` method and we mean by passing 3 to ensure the password appears less than 3 times in the same data leak */
            return Password::min(8)->uncompromised(3);
        });
    }
}
