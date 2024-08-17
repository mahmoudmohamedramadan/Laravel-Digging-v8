<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    /* We use session in web applications to store state between page requests. Laravel's session manager supports session drivers using `files`, `cookies`, `database`, and `Memcached` or `Redis` */

    public function index()
    {
        // The `put` method allows you to store key with its vlaue in session
        session()->put('welcomeMsg', 'Hola User!');

        // You can use the below syntax also
        // session(['welcomeMsg' => 'Hola User!']);

        return view('session.index');
    }

    public function sessionMethods()
    {
        /* The `get` method pulls the value of the provided key out of the session. If there is no value attached to that key, it will return the fallback value (and if you do not provide fallback will return `null`) */
        session()->get('$key', '$fallbackValue');

        // The `put` method stores the provided value in the session at the provided key
        session()->put('$key', '$value');

        /* NOTE: The `put` method allows you to add array value to the key while the `push` method will push a new value to exitance key of array */
        // session()->put('welcomeMsg', ['Welcome User!', 'Hola User!']);
        // session()->push('welcomeMsg', 'مرحبا');

        // The `has` method checks if session has value of specified key
        session()->has('$key');

        // The `exists` method checks if the session has specified key
        session()->exists('$key');

        // The `all` method returns an array of everything that's in the session
        session()->all();

        // The `forget` method removes a previously value of passed key
        session()->forget('$key');

        // The `flush` method removes every session value, even those set by laravel like `_token`
        session()->flush();

        /* The `pull` method is the same as `get` method, except that it deletes the value from the session after pulling it */
        session()->pull('$key', '$value');

        // It's not common, but if you need to regenerate your session ID, this method is there for you
        session()->regenerate();

        /* One very common pattern for session storage is to set a value that you only want available for the next page load, exe: you might want to store a message like `user updated`. you could manually get that message and then wipe it on the next page load, but if you use this pattern a lot it can be wastful */

        // The `flash` method sets the session key to the provided value for just the next page request
        session()->flash('$key', '$value');

        /* If you need the previous page's flash session data to stick around for one more request use `reflash` method to restore all of it for the next request */
        session()->reflash('$key', '$value');

        // If you want to restore a single flash value for the next request, you must use the `keep` method
        // NOTE: The `keep` method can also accept an array
        session()->keep('$key');
    }
}
