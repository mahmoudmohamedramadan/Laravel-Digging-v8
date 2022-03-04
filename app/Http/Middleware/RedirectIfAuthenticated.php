<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\{Http\Request, Support\Facades\Auth};

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard($guards)->check()) {
            return redirect(RouteServiceProvider::HOME);

            /* redirect when a user not authenticated to visit specific url */
            // return redirect()->guest('/home');

            /* `intended` method redirect you to the page which you go before auth middleware redirect you to login page */
            // return redirect()->intended();
        }

        return $next($request);
    }
}
