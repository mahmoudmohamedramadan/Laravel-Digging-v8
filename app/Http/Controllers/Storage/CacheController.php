<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /* The biggest difference between `Cache` and `Session`, is the data in cache is cached per application, and the data in a session is cached per user. That means caches are more commonly. The cache configuration settings are available at config/cache.php */
    public function index()
    {
        /* you can use `Cache` facades to access a cache */
        // Cache::get('users');

        /* also you can use `cache` helper method */
        // cache('$key', 'defaultCacheHelperValue');

        /* you can set keys and values in cache as first parameter and the second param is the duration of cache to leave */
        // cache(['newCacheKey' => 'newCacheValue'], 10000);

        /* this is another syntax to save data in cache */
        // cache()->put('newCacheKey', 'newCacheValue', 100);

        /* this is another syntex to get cache value */
        $aliasCacheHelperValue = cache()->get('newCacheKey', 'defaultCacheHelperValue');

        /* `get` makes it easy to retrieve the value for any given key, `pull` is the same as `get` except it remove the cached value after retrieving it */
        // cache()->pull('$key', '$fallbackValue');

        /* `add` is similar to `put`, except if the value is already exists, it won't set it. Also, the method returns a Boolean indicating wheter or NOT the value was actually added */
        // cache()->add('$key', '$value');

        /* `forever` saves a value to the cache for a specfic key; it's the same `put`, except the value will never expire[until they're removed WITH `forget`] */
        // cache()->forever('$key', '$value');

        /* `has` returns a Booleans indicating wheter or NOT there's a value set the provided key */
        // cache()->has('$key');

        /* `remember` check a value exists in the cache for a certain key; and if does NOT, get that value somehow, save it to the cache, and return it, also it provide the number of seconds to leave and, a closure to define how to look it up, in case the key has no value set. `rememberForever` is the same, except it does NOT need you to set the number of seconds to leave */
        // cache()->remember('$key', '$second', '$closure');
        // cache()->rememberForever('$key', '$closure');

        /* `increment` allow you to increment integer value in cache. If there is no value at the given key, it'll be treated as if it were 0, and if you pass a second param to increment or decrement, it'll increment or decrement by that amount instead of by 1 */
        // cache()->increment('$key', '$amount');
        // cache()->decrement('$key', '$amount');

        /* `forget` works just like Session's `forget` method: pass it a key and it'll wipe that's key's value. `flush` wipes the entire cache */
        // cache()->forget('$key');
        // cache()->flush();

        return view('cache.index', ['value' => $aliasCacheHelperValue]);
    }
}
