<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Support\Facades\Route, Support\Facades\Cookie};

class CookiesController extends Controller
{
    /* Cookies works same as `sessions` and `caches`, Cookies can exist in three places in Laravel, they can come in via the request, which means the user had the cookie when they visited the page. you can read that with the cookie facade, or you can read it off of the request object. They can also be sent out with a respose, which means the response will instruct the user's browser to save the cookie for future visits. you can do this by adding the cookie to your respose object before returning it. And lastly, a cookie can be queued. If you use the cookie facade to set a cookie, you have put it into a "CookieJar" queue, and it will be removed and added to the response object by the `AddQueuedCookiesToResponse` middleware */

    // The cookie facade, not allowing you only read and make cookies, but also to queue them to the response
    public function cookiesFacade()
    {
        // `get` method to pull the value of a cookie that came in with the request
        Cookie::get('$key');

        // You can check whethera cookie came in with the request using `has` method
        Cookie::has('$key');

        // If you want make a cookie without queueing it anywhere, you can use the `make` method
        Cookie::make('$cookieName', '$cookieValue', '$minutesToLeave', '$cookiePath', '$cookieDomain', '$cookieSecureOverHTTPS', '$cookieHTTPOnly', '$cookie_Raw_Which_Indicates_The_Cookie_Should_Be_Sent_without_URL_Encoding_', '$cookie_Same_Site_Indicates_Should_BE_Available_For_Cross_Site_Request');

        /* If you use the `make` method, you will still need to attach the cookie to your response, which we'll cover shortly. The `queue` method has same syntax as the `make` method but it enqueues the created cookie to be automatically attached to the response by middleware. If you'd like, you can also just pass a cookie you've created yourself into `queue` method */
        Cookie::queue('...$params');

        /* The `cookie` method global helper will return a `CookieJar` instance if you call it with no parameters. however, two of the most convenient methods on the cookie facade `has` and `get` methods -- exist only on the `Facade`, not on the `CookieJar`. So in this context global helper is actually less useful than the other options. The one task for which the cookie global helper is useful is creating a cookie. if you pass parameters to the `cookie` method */

        // Reading cookies from Request objects
        Route::get('dashboard', function (Request $request) {
            return $request->cookie('$key', false);
        });
    }
}
