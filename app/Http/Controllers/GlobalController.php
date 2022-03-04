<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\{Models\User, Jobs\TestJob};

class GlobalController extends Controller
{
    public function diveIntoArray()
    {
        /* # Arrays

        PHP's native array manipulation functions give us a lot of power, but sometimes there are standard manipulations we want to make that require unwieldy loops and logic checks. Laravel's array helpers make a few common array manipulations much simpler  */

        $users = User::get();

        /* `first` will take the first value in the passed array, and if you have an array that have muliple arrays inside it, `first` will return the first array and you can make a change on it, NOTE that `$key` carries the index of the current item */
        $arrValue = Arr::first($users, function ($user, $key) {
            return $user['name'] = 'Ali';
        });

        /* this helper method is removed */
        // array_first($users, function ($key, $value) {
        //     if ($key == 'name') {
        //         return $value;
        //     }
        // });

        /* `array_get` method, makes it easy to get values out of an array, with two added benefits: it won't throw an error if you ask for a key that doesn't exist (and you can provide defaults with the third parameter), and you can use dot notation to traverse nested array */
        $array = [
            'owner' => [
                'address' => [
                    'line1' => 'Mansoura'
                ],
            ]
        ];

        /* `has` check if the passed key is exist in the given array */
        if (Arr::has($array, 'owner')) {
            /* here the result will be `Mansoura`, becuase there is an address given */
            $line1 = Arr::get($array, 'owner.address.line1', 'no address given!');
            /* but here there is no key with `line2`, so the result will be `no address given` */
            $line2 = Arr::get($array, 'owner.address.line2', 'no address given!');
        }

        /* `pluck()` method returns array of values corresponding to the provided key */
        $owners = [
            [
                'owner' => [
                    'id' => 1,
                    'name' => 'user 1',
                ],
            ],
            [
                'owner' => [
                    'id' => 2,
                    'name' => 'user 2',
                ],
            ],
        ];

        /* here will returns the all values in the passed array wih `name` key, and will make it's keys the values of the third passed param, EX: '1' : 'user 1', will take the keys from the third param and the values from the second param */
        Arr::pluck($owners, 'owner.name', 'owner.id');

        /* returns a random item from the provided array. if you provide the second param, it'll pull an array of that amny results */
        Arr::random($owners);
        /* an allias to `htmlentities()`; prepares a string for safe echoing on an HTML page, NOTE that you should echo out it */
        // echo e('<script>alert("Welcome");</script>');

        /* `dot` method represents the array into this form `level.level2.level3` */
        Arr::dot($array);

        /* `undot` method is the inverse of the `dot` method */
        Arr::undot($array);
    }

    public function applicationPATHS()
    {
        /* when you're dealing WITH the filesystem, it can often be tedious to make links to certain directories for getting and saving files. These helpers give you quick access to find the fully qulified paths to some of the most important directories in your app. */

        /* returns the path for the app directory */
        app_path('');

        /* return the path for he root directory of your app */
        base_path('');

        /* returns the path for configuration files in your app */
        config_path('');

        /* returns the path for database files in your app */
        database_path('');

        /* returns the path for the storage directory in your app */
        storage_path('');
    }

    public function diveIntoURL()
    {
        /* `action` method will assuming a controller method has a single URL mapped to it, returns the correct URL given a controller and method name pair (separated by @) or using tuple notation */
        '<a href="{{ action("UserController@index") }}">All Users</a>';

        /* tuple notation */
        '<a href="{{ action([UserController::class, "index"]) }}">All Users</a>';

        /* and if you want to pass some paramters do that */
        '<a href="{{ action("UserController@index", ["id" => 1, .....]) }}">All Users</a>';

        /* using `route` helper, btu at the first you should add name for any route to access it */
        /* in `web.php` >> Route::get('welcomeRoute/{id}', function() {})->name('test'); */
        '<a href="{{ route("test", 50) }}">All Users</a>';

        /* in case of there are multiple segments pass them as array */
        '<a href="{{ route("test", ["id" => 50]) }}">All Users</a>';

        /* `url` and `secure_url` */
        /* given any path string, converts to fully qualified URL */

        /* `url` returns http::localhost:8000/globals */
        url('/globals');

        /* `current` returns the current URL */
        url()->current();

        /* `full` return all URL including a query string */
        url()->full();

        /* `previous` returns the previous URL */
        url()->previous();
    }

    public function Miscellaneous()
    {
        /* here always will abort the user */
        // abort(403, 'you shall NOT pass');

        /* here will abort the user ONLY if NOT the `token` filled WITH value */
        abort_unless(request()->filled('token'), 403, 'you shall NOT pass the token');

        /* here will abort the user ONLY if the `token` filled WITH value */
        abort_if(!request()->filled('token'), 403, 'you shall NOT pass the token');

        /* here will check if the current user is authenticated or NOT */
        if (auth()->check()) {
            /* `auth` returns an instance of the Laravel authenticator, Like the Auth facade, you can use this to get the current user, to check for login state, and more */
            auth();

            /* here you'll get the authenticated user */
            auth()->user();

            /* here you'll get the authenticated user's id */
            auth()->id();
        }

        /* `redirect` will redirect the user to the previous page, and equals to `back` */
        redirect()->back();

        /* `collect` tasks an array and returns the same data, converted to a collection */
        collect();

        /* `config` returns the value for any dot-notated configuration item */
        config();

        /* `csrf_field` generates a token */
        csrf_field();

        /* `dd` short for `Dump and Die` runs `var_dump` on all provided parameters and then `exit` */
        dd('www', 'hhhh', 'nnnn');

        /* `env` returns the environment variable for the given key */
        env('APP_DEBUG');

        /* `dispatch` dispatches the job */
        dispatch(TestJob::class);

        /* `event` fires an event */
        event();

        /* `old` returns the old value for this form key, if it exists */
        old('$key', '$default');

        /* `redirect` returns a redirect response to the given path */
        redirect();

        /* `response` if passed WITH parameters, returns a prebuilt instance of response. if passed WITH no response, it returns an instance of the response factory */
        response('$content', '$status', ['$headers']);

        /* `view` returns a view instance */
        view();
    }
}
