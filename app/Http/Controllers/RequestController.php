<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

use function App\Helpers\json_response;

class RequestController extends Controller
{
    public function requestView()
    {
        return view('request');
    }

    /* PHP 8.1 adds support for `intersection types`. It’s similar to `union types` introduced in PHP 8.0, but their intended usage is the exact opposite, Essentially, you can add type declarations to function arguments, return values, and class properties. This assignment is called `type hinting` and ensures that the value is of the correct type at call time. Otherwise, it throws up a TypeError right away. In turn, this helps you debug code better */

    ## Intersection type: requires a value to satisfy multiple type constraints instead of a single one
    /* NOTE: The usage of `& (AND)` operator to declare `intersection types`. In contrast, we use the `| (OR)` operator to declare `union types` */
    public function indexPost(Request|FacadesRequest $request)
    {
        /* The below line has a very awesome feature (Named Parameter) that not force you to pass a parameter that you not want to pass */
        // Request::create(uri: 'my_url', method: 'POST', content: 'my_content');

        if (!$request->method() == 'POST' && !$request->isMethod('POST')) {
            return false;
        }

        // The `all` method to get all the keys in the request
        $request->all();

        // The `only` method to get only specified key(s)
        $request->only('_token');
        $request->only(['_token' . 'first_name']);

        // The `except` method to get all the keys excepts specific key(s)
        $request->except('_token');
        $request->except(['_token', 'last_name']);

        // The `query` method will only retrieve values from the query string
        $request->query('_token');

        /* When dealing with HTML elements like checkboxes, your application may receive "truthy" values that are actually strings. For example, "true" or "on". For convenience, you may use the `boolean` method to retrieve these values as booleans */
        $request->boolean('_token');

        /* The `has` method used to check for if the request has this key and not mandatory to be filled and `filled` method check if this key is empty or not */
        if (!$request->has('first_name')) {
            return json_response(false, 'The request must has first_name key');
        } else if (!$request->has('last_name')) {
            return json_response(false, 'The request must has last_name key');
        } elseif (!$request->filled('first_name')) {
            return json_response(false, 'The First Name must be filled');
        } else if (!$request->filled('last_name')) {
            return json_response(false, 'The Last Name must be filled');
        }

        // The `input` method used to key the value of the input's name
        return json_response(
            true,
            "Your name is {$request->input('first_name')} {$request->get('last_name')}"
        );
    }

    public function indexGet(Request $request)
    {
        /* `segments` method used to get all url segment >> EX: http://127.0.0.1:8000/requestGet/Mahmoud/Osama?first=&last= segments will return `requestGet` and `Mahmoud` and `Osama` */
        // $request->segments();

        // The `segment` method used to return a segment with the index of 1
        return $request->segment(2);
    }

    public function indexPostFile(Request $request)
    {
        if (!$request->has('file')) {
            $request->validate(['file' => 'required']);
        }

        $request->validate([
            'file' => 'image|mimes:png,jpg|max:2500'
        ]);

        // The `isValid` method check if the file uploaded successfully or not
        if (!$request->file('file')->isValid()) {
            return false;
        }

        // The `hasfile` method check if this request has specific key or not
        if ($request->hasFile('file')) {
            return $request->file('file')->getError();
        }

        // The `file` method to get the uploaded file with the name of input's file
        $request->file('file');

        // The `allFiles` method returns an array with all uploaded files
        $request->allFiles();

        $request->file->guessExtension();

        /* The `store` method will save files inside new storage folder(app/storage) and if you want this file saved inside another folder put the folder's name in first parameter */
        // $request->file->store('', 'local');

        /* When you link the storage, the main `storage` in app folder will be binded with `storage` in public folder and do not try to delete file in binded folder (app/storage) because this will lead to ERROR */
        // $request->file->store('', 'public');

        /* The `store` will save files inside created `users` disk (created in filesystems.php) inside another folder called newFolder */
        // $request->file->store('/newFolder', 'users');

        /* The `storeAs` accepts three parameters, The first one the folder and the second is the new name for the file (do not forget the extension) and the third is the disk name */
        // $request->file->storeAs('/newFolder', 'newName.png', 'users');

        // $request->file->storePublicly('publiclyFolder', 'users');
        // $request->file->storePubliclyAs('publiclyFolder', 'newPubliclyFile.png', 'users');

        // $request->file('file')->move('moveFolder', 'moveFile.png');
        // $request->file->getClientOriginalExtension();
        // $request->file->getClientOriginalName();
        // $request->file->getmimeType();
    }

    public function userRequestAndState(Request $request)
    {
        // The `capture` method used to get more info about the server request
        // dd($request->capture());
        // dd(request()->capture());

        // The `all` method used to get all the data sent with the request
        // dd($request->all());
        // dd(request()->all());

        // You may also print all the request info through the below two lines
        // dd(app(Request::class));
        // dd(app('request'));

        // The `exists` method check if the passed key exists in the coming request or not
        if (!$request->exists('email')) {
            dd('An error has occured, token does not sent');
        }

        /* The `path` method get url without domain EX: if you in `http://127.0.0.1:8000/users/3`, `path` method will return `users/3`, `url` method returns the url without the query string, and `fullUrl` method return the url with a query string */
        if (!str_contains($request->path(), 'requestMethods') and !str_contains($request->url(), 'requestMethods')) {
            return false;
        }

        $response = 'not INITIALIZED';
        // The `is` method return boolean indicating whetheror not, NOTE the `*` means anything
        $response = $request->is('*com') ?: 'INVALID'; // This is good way to check about something
        $response ??= $request->is('*com'); // But this is better way to check about something

        // The `ip` method returns the user's IP address like 127.0.0.1
        dump('Dear ' . $request->ip() . ', please enter valid url');

        // The `header` method returns an array of headers like [host, connection, cookie, ....]
        dump($request->header());

        // The `server` method returns an array of variables traditionally stored in the `$_SERVER`
        dump($request->server());

        // The `secure` method check if current HTTP protocol is secure [HTTPS] or not
        dump($request->secure());

        // The `pjax` method returns a boolean indicating whetherthis page was loaded using Pjax
        /* For more info: https://clarle.github.io/yui3/yui/docs/pjax/#:~:text=Pjax%20is%20a%20technique%20that,avoiding%20a%20full%20page%20load */
        dump($request->pjax());

        /* The `wantsJson` method returns a boolean indicating whetherthis page request has any json content */
        dump($request->wantsJson());

        /* The `accepts` or `acceptsHtml` methods returns a boolean indicating whetherthis page request accepts a given content type */
        dump($request->accepts('html'), $request->acceptsHtml());
    }

    public function persistenceRequest(Request $request)
    {
        /* `flash` method used to flash the current request's user input to the session to be retrieved later */
        // $request->flash();

        // `flashOnly` method work same as flash, but with `flashOnly` you specifiy the keys which you want to be flashed
        $request->flashOnly(['first_name']);

        /* `flashExcept` method also work same as flash, but `flashExcept` method flash all user's inputs except the keys which you want */
        $request->flashExcept(['first_name']);

        // `old` method returns an array of all prevoiusly flashed user input
        $request->old();

        // `flush` method wipes all prevoiusly user input
        $request->flush();

        // `cookie` method return all cookies from this request
        dump($request->cookie());

        // `hasCookie` method check if this request has a cookie with this key
        dump($request->hasCookie('blaa'));

        return redirect()->back();
    }
}
