<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomMiddleware
{
    /* The idea of middleware is that there are a series of layers wrapping around your application, like onion. every request passes through every middleware layer on is way into the application, and then the resulting response passes back through the middleware layers on its way out to the end user */

    /* First, remember that middleware are layerd one on top of another, and then finally on top of the app. The first middleware that's registered get first access to a request when it comes in, then that request is passed to every other middleware in turn, then to the app; then the resulting respone is passed outward through the middleware, and finally this first middleware get last access to the response when it goes out */


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, $view)
    {
        /* `$next` means handling it off to the rest of the middleware, The `$next` closure just takes that `$request` and passes it to the `handle` method of the next middleware in the stack, it then gets passed on down the line until there are no more middleware to hand it out */

        if ($request->ip() != '127.0.0.1' or $role == 'admin' or $view != 'home.blade.php') {
            return response('invalid info');
        }

        $response = $next($request);
        $response->cookie('visited-our-site', true);

        return $response;
    }
}
