<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storage\CacheController;

## Route Caching

/* Because of the way that Laravel runs, it boots up the framework and parses the routes file on each request that is made. This requires reading the file, parsing its contents, and then holding it in a way that your application can use and understand. So, Laravel provides a command that you can use which creates a single routes file that can be parsed much faster: >> `php artisan route:cache` */

/* NOTE: If you use this command and change your routes, you’ll need to make sure to run >> `php artisan route:clear`, This will remove the cached routes file so that your newer routes can be registered */

## Config Caching

/* Similar to the route caching, each time that a request is made, Laravel is booted up and each of the config files in your project are read and parsed. So, to prevent each of the files from needed to be handled, you can run the following command which will create one cached config file >> `php artisan config:cache` */

/* Just like the route caching above though, you’ll need to remember to run the following command each time you update your `.env` file or config files */

## Event and View Caching

/* Laravel also provides two other commands that you can use to cache your views and events so that they are precompiled and ready when a request is made to your application. To cache the events and views, you can use the following commands >>
1. `php artisan event:cache` 2. `php artisan view:cache` */

/* Like all the other caching commands, though, you'll need to remember to bust these caches whenever you make any changes to your code by running the following commands >> 1. `php artisan evevnt:clear` 2. `php artisan view:clear` */

/* Within your Laravel app’s code, you can cache items to improve the website’s performance. As an example, imagine you have the following query */
// Cache::remember('users', 120, function () {
//     return DB::table('users')->get();
// });

/* The code above uses the `remember` method. What this basically does is it checks if the cache contains any items with the key `users`. If it does, it returns the cached value. If it doesn’t exist in the cache, the result of the `DB::table('users')->get()` query will be returned and also cached. In this particular example, the item would be cached for 120 seconds.Caching data and query results like this can be a really effective way of reducing database calls, reducing runtime, and improving performance. However, it’s important to remember that you might sometimes need to remove the item from the cache if it’s no longer valid */

/* Using the example above, imagine that we have the user’s query cached. Now imagine that a new user has been created, updated, or deleted. Thatcached query result is no longer going to be valid and up to date. To fix this
issue, we could make use of Laravel model observers to remove this item from the cache. This means that next time we try and grab the `$users` variable, a new database query will be run that will give us the up-to-date result. */

Route::get('caching-index', [CacheController::class, 'index']);
