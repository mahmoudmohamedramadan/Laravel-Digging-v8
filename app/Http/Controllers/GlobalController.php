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
        /* PHP's native array manipulation functions give us a lot of power, but sometimes there are standard manipulations we want to make that require unwieldy loops and logic checks. Laravel's array helpers make a few common array manipulations much simpler */

        $users = User::get();

        /* `first` will take the first value in the passed array, and if you have an array that have multiple arrays inside it, `first` will return the first array and you can make a change on it, NOTE: `$key` carries the index of the current item */
        Arr::first($users, function ($user, $key) {
            return $user['name'] = 'Ali';
        });

        /* `array_get` method, makes it easy to get values out of an array, with two added benefits: it won't throw an error if you ask for a key that doesn't exist (and you can provide defaults with the third parameter), and you can use dot notation to traverse nested array */
        $array = [
            'owner' => ['address' => ['line1' => 'Mansoura']]
        ];

        // `has` method check if the passed key is exist in the given array
        if (Arr::has($array, 'owner')) {
            // here the result will be `Mansoura`, becuase there is an address given
            Arr::get($array, 'owner.address.line1', 'no address given!');

            // but here there is no key with `line2`, so the result will be `no address given`
            Arr::get($array, 'owner.address.line2', 'no address given!');
        }

        // `pluck` method return an array of values corresponding to the provided key
        $owners = [
            ['owner' => ['id' => 1, 'name' => 'user 1']],
            ['owner' => ['id' => 2, 'name' => 'user 2']]
        ];

        /* `pluck` method will return all values in the passed array with `name` key, and will make its keys the values of the third passed param, EX: '1': 'user 1', will take the keys from the third param and the values from the second param */
        Arr::pluck($owners, 'owner.name', 'owner.id');

        /* `random` method returns a random item from the provided array. if you provide the second param, it'll pull an array of that any results */
        Arr::random($owners);

        /* `e` method an allias to `htmlentities()`; prepares a string for safe echoing on an HTML page, NOTE you should echo out it */
        // echo e('<script>alert("Welcome");</script>');

        // `dot` method represents the array into this form `level.level2.level3`
        Arr::dot($array);

        // `undot` method is the inverse of the `dot` method
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

        // `app_path` method returns the path for the app directory
        app_path('');

        // `base_path` method return the path for he root directory of your app
        base_path('');

        // `config_path` method returns the path for configuration files in your app
        config_path('');

        // `database_path` method returns the path for database files in your app
        database_path('');

        // `storage_path` method returns the path for the storage directory in your app
        storage_path('');
    }

    /**
     * Dive into the URL methods.
     *
     * @return void
     */
    public function diveIntoURL()
    {
        /* `action` method will assuming a controller method has a single URL mapped to it, returns the correct URL given a controller and method name pair (separated by @) or using tuple notation */
        '<a href="{{ action("UserController@index") }}">All Users</a>';

        // same result of the upper line but in tuple notation
        '<a href="{{ action([UserController::class, "index"]) }}">All Users</a>';

        // If you want to pass some paramters do like so
        '<a href="{{ action("UserController@index", ["id" => 1]) }}">All Users</a>';

        /* Using `route` helper, but at the first you should add name for any route to access it, in `web.php` >> Route::get('welcomeRoute/{id}', function() {})->name('test'); */
        '<a href="{{ route("test", 50) }}">All Users</a>';

        // In case of there are multiple segments pass them as array
        '<a href="{{ route("test", ["id" => 50]) }}">All Users</a>';

        // `url` and `secure_url`, given any path string, converts to fully qualified URL

        // `url` method returns `http::localhost:8000/globals`
        url('/globals');

        // `current` method returns the current URL
        url()->current();

        // `previous` method returns the previous URL
        url()->previous();
    }

    /**
     * Use a miscellaneous helper methods.
     *
     * @return void
     */
    public function Miscellaneous()
    {
        // `abort` method always aborts the user
        // abort(403, 'you shall not pass');

        // `abort_unless` method will aborts the user only if not the `token` filled with value
        abort_unless(request()->filled('token'), 403, 'you shall not pass the token');

        // `abort_if` method will aborts the user only if the `token` filled with value
        abort_if(!request()->filled('token'), 403, 'you shall not pass the token');

        // Check if the current user is authenticated or not
        if (auth()->check()) {
            /* `auth` method returns an instance of the Laravel authenticator, Like the `Auth` facade, you can use this to get the current user */
            auth();

            // Using the below line you'll get the authenticated user
            auth()->user();

            // Using the below line you'll get the authenticated user's id
            auth()->id();
        }

        // `redirect` method will redirect the user to the previous page, and equals to the `back` method
        redirect()->back();

        // `collect` method tasks an array and returns the same data, converted to a collection
        collect();

        // `config` method returns the value for any dot-notated configuration item
        config();

        // `csrf_field` method generates a token
        csrf_field();

        // `dd` method shorthand for `Dump and Die` runs `var_dump` on all provided parameters and then `exit`
        dd('www', 'hhhh', 'nnnn');

        // `dd` method shorthand for `Dump, Die, Debug`
        ddd('www', 'hhhh', 'nnnn');

        // `env` method returns the environment variable for the given key
        env('APP_DEBUG');

        // `dispatch` method dispatches the job
        dispatch(UserReports::class);

        // `event` method fires an event
        event();

        // `old` method returns the old value for this form key, if it exists
        old('$key', '$default');

        // `redirect` method returns a redirect response to the given path
        redirect();

        /* `response` method if passed with parameters, returns a prebuilt instance of response. if passed with no response, it returns an instance of the response factory */
        response('$content', '$status', ['$headers']);

        // `view` method returns a view instance
        view();
    }
}
