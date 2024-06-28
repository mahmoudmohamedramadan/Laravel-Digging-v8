<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /* NOTE: every request passes through the `$middleware` array also, not all pass through the `$middleware Groups`, and to passes, the route must be under any key on this array such as [web, api] */

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        /* Trust Proxies[load balancer], Laravel detects whether the current request was via HTTP or HTTPS and in order to make, Laravel correctly treat proxied HTTPS calls like secure calls, and in order for Laravel to process oher headers from proxied requests, You likely do not just want o alow any proxy to send traffic to your app */
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        /* Here: we registered our middleware globally or we can register it for a specific route that can be added as middleware in `$routeMiddleware`, NOTE: to pass your parameters write `middlewareName: param_1, param_2` also, NOTE: if you registered your custom middleware here you will have to pass all new parameters [$role, $view], so you should register it into the `$routeMiddleware` */

        // \App\Http\Middleware\CustomMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'custom-middleware' => \App\Http\Middleware\CustomMiddleware::class,

        // Passport Middleware
        'scope' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
        'scopes' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
    ];
}
