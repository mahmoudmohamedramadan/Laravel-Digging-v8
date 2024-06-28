<?php

use App\Models\User;
use Illuminate\Support\Facades\{Http, Route};

/* Passport makes it possible for you to authenticate users in four different ways. Two are traditional OAUTH 2.0 grants [the password grant and authorization code grant] and two are convenience methods that are unique to Passport [the personal token and synchronizer token] */

/* Via this route you can create token for first user to use it in login process, you must create a personal token using `php artisan passport:install` this command creates a two keys in the `storage` folder, also creates a two records into database one is `Laravel Personal Access Client` and the other is `Laravel Password Grant Client`, or you can run `php artisan passport:client --personal`  */
Route::get('passport/createToken', function () {
    // `API Token` the name of token that used in `oauth_access_tokens` table
    return User::first()->createToken('API Token')->accessToken;
});

// This route will return the token of the first user
Route::get('passport/getToken', function () {
    return User::first()->token();
});

/* ## Password grant: The password grant, while less common than the authorization code grant, is much simpler. If you want users to be able to authenticate directly with your API using thier username and password, in order to use the password grant flow, you need a password grant client in your database.this is because every request to an OAUTH server needs to be made by a client*/
Route::get('/passport/password-grant', function () {
    /* When you deal with password grant do not forget to set `password_client` to `1`, The passed value to the `$url` parameter in the `post` method is the URL inside this application, `client_id` is the value that exists in `oauth_access_tokens` table */
    return Http::asForm()->post('http://laravel-digging.com/oauth/token', [
        'grant_type' => 'password',
        'client_id' => '1',
        'client_secret' => 'rZkmvFBqTu00hzb48k6Siutm4uqO6I0NkxbKE9y4',
        'username' => 'admin@gmail.com',
        'password' => 'admin',
        'scope' => '',
    ])->json();
});

### From the upper route will return four important key are

/* access_token: this token which Laravel-Digging project will save for this user. This token is what the user will user to authenticate in future requests to `book.try.com`

refresh_token: a token Laravel-Digging project will need if you decide to set your tokens to expire. By defualt, Passport's access tokens last for one year

expires_in: the number of seconds until an `access_token` expires [needs to be refreshed]

token_type: the type of token you're getting back, which will be Bearer; this means you pass a header with all future requests with the name of Authorization and the value of Bearer `YOURTOKENHERE` */

/* If you'd like to force users to reauthenticate more often, you need to set a shorter refresh time on the tokens, and then you can use the refresh_token to request a new `access_token` when needed */

/* There's one final way for your users to get tokens to access you API, and it's another convenience method that Passport adds but normal OAUTH servers do not provide. This method is for when your users are already authenticated because they've logged in to your Laravel app like normal, and you want your app's JavaScript to be able to access the API, It'd be a pain to have to reauthenticate the users with the authorization code or password grant flow. So Laravel provides a helper for that

If you add the `Laravel\Passport\Http\Middleware\CreateFreshApiToken` middleware to your we middleware group in app\Http\Kernel.php, every response Laravel sends to your authenticated users will have a cookie named laravel_token attached to it, This cookie is a JSON Web Token [JWT] that contains encoded information about the CSRF token */

/* JSON Web Token is a JSON object containing all of the inforamtion to determine a user's authentication state and access permissions. This JSON object is digitally signed using keyed-hash-message authentication do [HMAC] or RSA

JSON Web Token consist of three Base64-encoded strings separated by dots[.]; something like xxx.yyy.zzz

$.ajaxSetup({
    headers: {
        'X-CRSF-TOKEN': "{{ csrf_token() }}",
        'X-Request-With': "XMLHttpRequest",
    }
});

If you add the `CreateFreshApiToken` middleware to your we middleware group and pass those headers with every JavaScript request will be able to hit your Passport-protect API routes without worring about any of the complexity of the authorization code or password grants.
*/

### The easiest way to dig into the API routes is ny looking at how the sample provided
/*
/oauth/clients [GET, POST]
/oauth/clients{id} [DELETE, PUT]
/oauth/personal-access-token [GET, POST]
/oauth/personal-access-token/{id} [DELETE]
/oauth/scopes [GET]
/oauth/tokens [GET]
/oauth/tokens/{id} [DELETE]

Passport comes with a set of Vue components out of the box that makes it easy to alow your users to administer clients
To publish thses components into your application, run this command >> php artisan publish:vendor --tag=passport-components
Then open resources/js/app.js and finally call these compoenents into home.blade.php
*/

### Passport Scopes
/* In OAuth, scopes are defines sets of privileges that are something other tha, you might've noticed that some app want apps access just to your name and email address, some want access to all of your repos [in GitHub], you can define the scopes for your application in boot() method of your AuthServiceProvider then use it as next request */
Route::get('twitter/redirect', function () {
    $query = http_build_query([
        'client_id' => 1,
        'redirect_url' => 'test/test',
        'response_type' => 'code',
        'scope' => 'list-clips add-delete-clips' // You can add mutliple scopes
    ]);

    return redirect('http://bla/bla?' . $query);
});

// You can check for scope using middleware or on the user instance
Route::get('/events', function () {
    if (auth()->user()->tokenCan('add-delete-clips')) {
        // Do something here...
    }
});

Route::get('clips', function () {
    // Do something here...
})->middleware('scopes:list-clips, add-delete-clips');
