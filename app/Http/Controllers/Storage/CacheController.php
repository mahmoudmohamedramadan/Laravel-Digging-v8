<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /* The biggest difference between `Cache` and `Session`, is the data in cache is cached per application, and the data in a session is cached per user. That means caches are more commonly. The cache configuration settings are available at `config/cache.php` */
    public function index()
    {
        // You can use the `Cache` facade or you can use the `cache` helper method to access the cache
        // Cache::get('users');
        // cache('$key', 'defaultCacheHelperValue');

        /* You can set the `keys` and `values` in the cache as first parameter and the second param is the `duration` of cache to leave */
        // cache(['newCacheKey' => 'newCacheValue'], 10000);

        // This is another syntax to save data in cache
        // cache()->put('newCacheKey', 'newCacheValue', 100);

        // This is another syntex to get cache value
        $aliasCacheHelperValue = cache()->get('newCacheKey', 'defaultCacheHelperValue');

        /* The `get` method makes it easy to retrieve the value for any given key, `pull` method is the same as the `get` method except it remove the cached value after retrieving it */
        // cache()->pull('$key', '$fallbackValue');

        /* The `add` method is similar to the `put` method, except if the value is already exists, it won't set it. Also, the method returns a Boolean indicating whetheror not the value was actually added */
        // cache()->add('$key', '$value');

        /* The `forever` method saves a value to the cache for a specfic key; it's the same the `put` method, except the value will never expire (until they're removed with `forget` method) */
        // cache()->forever('$key', '$value');

        // The `has` method returns a boolean indicating whether or not there's a value set in the provided key
        // cache()->has('$key');

        /* The `remember` method check a value exists in the cache for a certain key; and if does not, get that value somehow, save it to the cache, and return it, also it provide the number of seconds to leave and, a closure to define how to look it up, in case the key has no value set */
        // cache()->remember('$key', '$second', '$closure');

        // The `rememberForever` method is the same, except it does not need you to set the number of seconds to leave
        // cache()->rememberForever('$key', '$closure');

        /* The `increment` method allows you to increment integer value in cache. If there is no value at the given key, it'll be treated as if it were `0`, and if you pass a second param to increment or decrement, it'll increment or decrement by that amount instead of by `1` */
        // cache()->increment('$key', '$amount');
        // cache()->decrement('$key', '$amount');

        // The `forget` method wipes The given key's value.
        // cache()->forget('$key');

        // The `flush` method wipes the entire cache
        // cache()->flush();

        return view('cache.index', ['value' => $aliasCacheHelperValue]);
    }
}
