<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\{Models\User, Jobs\UserReports};

class GlobalController extends Controller
{
    /**
     * Dive into array methods.
     *
     * @return void
     */
    public function diveIntoArray()
    {
        $users = User::get();

        /* The `first` method will take the first value in the passed array, and if you have a nested array, it will return the first array */
        // NOTE: The `$key` carries the index of the current item
        Arr::first($users, function ($user, $key) {
            return $user['name'] = 'Ali';
        });

        /* The `array_get` method, makes it easy to get values out of an array, with two added benefits: it won't throw an error if you ask for a key that doesn't exist (and you can provide defaults with the third parameter), and you can use dot notation to traverse nested array */
        $array = [
            'owner' => ['address' => ['line1' => 'Mansoura']]
        ];

        // The `has` method check if the passed key is exist in the given array
        if (Arr::has($array, 'owner')) {
            // here the result will be `Mansoura` because there is an address given
            Arr::get($array, 'owner.address.line1', 'no address given!');

            // But here there is no key with `line2`, so the result will be `no address given`
            Arr::get($array, 'owner.address.line2', 'no address given!');
        }

        $owners = [
            ['owner' => ['id' => 1, 'name' => 'user 1']],
            ['owner' => ['id' => 2, 'name' => 'user 2']]
        ];

        /* The `pluck` method will return all values in the passed array with the `name` key, and will make its keys the values of the third passed param, EX: '1', 'user 1', will take the keys from the third param and the values from the second param */
        Arr::pluck($owners, 'owner.name', 'owner.id');

        /* The `random` method returns a random item from the provided array. if you provide the second param, it'll pull an array of that any results */
        Arr::random($owners);

        /* The `e` method an allias to `htmlentities()`; prepares a string for safe echoing on an HTML page */
        // NOTE: You should echo out it
        // echo e('<script>alert("Welcome");</script>');

        // The `dot` method represents the array into this form `level.level2.level3`
        Arr::dot($array);

        // The `undot` method is the inverse of the `dot` method
        Arr::undot($array);
    }

    /**
     * Use the path helper methods.
     *
     * @return void
     */
    public function applicationPATHS()
    {
        /* When you're dealing with the filesystem, it can often be tedious to make links to certain directories for getting and saving files. These helpers give you quick access to find the fully qulified paths to some of the most important directories in your app. */

        // The `app_path` method returns the path for the app directory
        app_path('');

        // The `base_path` method return the path for he root directory of your app
        base_path('');

        // The `config_path` method returns the path for configuration files in your app
        config_path('');

        // The `database_path` method returns the path for database files in your app
        database_path('');

        // The `storage_path` method returns the path for the storage directory in your app
        storage_path('');
    }

    /**
     * Dive into the URL methods.
     *
     * @return void
     */
    public function diveIntoURL()
    {
        /* The `action` method will assuming a controller method has a single URL mapped to it, returns the correct URL given a controller and method name pair (separated by @) or using tuple notation */
        '<a href="{{ action("UserController@index") }}">All Users</a>';

        // The same result of the upper line but in tuple notation
        '<a href="{{ action([UserController::class, "index"]) }}">All Users</a>';

        // If you want to pass some paramters do like so
        '<a href="{{ action("UserController@index", ["id" => 1]) }}">All Users</a>';

        // The same result using the `route` helper, but at the first you should add that name
        '<a href="{{ route("test", 50) }}">All Users</a>';

        // In case of there are multiple segments pass them as array
        '<a href="{{ route("test", ["id" => 50]) }}">All Users</a>';

        // The `url` method returns `http::localhost:8000/globals`
        url('/globals');

        // The `current` method returns the current URL
        url()->current();

        // The `previous` method returns the previous URL
        url()->previous();
    }

    /**
     * Use a miscellaneous helper methods.
     *
     * @return void
     */
    public function Miscellaneous()
    {
        // The `abort` method always aborts the user
        // abort(403, 'you shall not pass');

        // The `abort_unless` method will aborts the user only if not the `token` filled with value
        abort_unless(request()->filled('token'), 403, 'you shall not pass the token');

        // The `abort_if` method will aborts the user only if the `token` filled with value
        abort_if(!request()->filled('token'), 403, 'you shall not pass the token');

        // Check if the current user is authenticated or not
        if (auth()->check()) {
            // The `auth` method returns an instance of the Laravel authenticator
            auth();

            // The below line you'll get the authenticated user
            auth()->user();

            // The below line you'll get the authenticated user's id
            auth()->id();
        }

        // The `back` method will redirect the user to the previous page
        redirect()->back();

        // Then `collect` convert the given array to an instance of `Illuminate\Support\Collection`
        collect();

        // The `config` method returns the value for any dot-notated configuration item
        config();

        // The `csrf_field` method generates a token
        csrf_field();

        /* The `dd` method shorthand for `Dump and Die` runs `var_dump` on all provided parameters and then `exit` */
        dd('www', 'hhhh', 'nnnn');

        // The `dd` method shorthand for `Dump, Die, Debug`
        ddd('www', 'hhhh', 'nnnn');

        // The `env` method returns the environment variable for the given key
        env('APP_DEBUG');

        // The `dispatch` method dispatches the job
        dispatch(UserReports::class);

        // The `event` method fires an event
        event();

        // The `old` method returns the old value for this form key, if it exists
        old('$key', '$default');

        // The `redirect` method returns a redirect response to the given path
        redirect();

        /* The `response` method returns a prebuilt response instance if parameters were passed, whereas, if passed with no content, it returns a response factory instance */
        response('$content', '$status', ['$headers']);

        // The `view` method returns a view instance
        view();
    }
}
