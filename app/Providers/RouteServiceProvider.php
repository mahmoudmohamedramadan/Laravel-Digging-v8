<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\{Http\Request, Support\Facades\Route, Cache\RateLimiting\Limit, Support\Facades\RateLimiter};

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        /* `model` method works as you say that, every `comment` segement name will be binded to the `Comment` model  */
        // Route::model('comment', Comment::class);

        /* `bind` method will bind the given segment name with whatever returned value from the closure, NOTE the argument in the closure will equals the value that you pass in url */
        // Route::bind('comment', function($comment) {
        //     return Comment::find($comment);
        // });

        /* By default, `Route::resource` will create resource URIs using English verbs. If you need to localize the create and edit action verbs, you may use the Route::resourceVerbs method */
        // Route::resourceVerbs([
        //     'create' => 'crear',
        //     'edit' => 'editar',
        // ]);

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/passport_api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/book.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/globals.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/query_builder.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/relationships.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/storage.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/session.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/cache.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/mail_notifications.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/new_features.php'));

            Route::namespace($this->namespace)
                ->group(base_path('routes/loops.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
