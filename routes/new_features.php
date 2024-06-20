<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewFeaturesController;

Route::any('/anyRequest', function () {
    // `any` method makes the URL familiar with any HTTP verb
    dd('welcome');
});

// If you have many URIs but different in HTTP verb only you can use the `match` method in that case
Route::match(['post', 'get'], '/matchRequest', function () {
    dd('welcome');
});

Route::get('newRoutes/{user}', function (User $user) {
    // The next two lines check the name of the current route
    // return request()->route()->named('newLaravel');
    // return request()->routeIs('newLaravel');

    return $user;
})
    /* NOTE middleware `web` very important in route model binding, because the `web middleware group` has `SubstituteBindings` that used in binding */
    ->middleware('web')
    ->name('newLaravel')
    ->where('id', '[0-9]+')
    ->whereNumber('id')
    /* If the given user id was not found and the user was deleted using `softDelete` the `withTrashed` will return this user */
    ->withTrashed()
    /* If the given user id was not found and was deleted permenantly so, `missing` will take a specific action within its closure (mostly you will redirect the user to another route) */
    ->missing(function () {
        return redirect()->route('welcome');
    });

Route::resource('user-new-features', NewFeaturesController::class)
    ->middleware('web')
    // You can exclude some resource functions from your route using `except`
    ->except(['edit', 'update', 'destroy'])
    /* `name` method allows you to change the route's name of any route, EX: to access create route name you will not use `route('newControllers.create)` but you will use `route('user_new_features.user_new_feature)` */
    ->name('create', 'user_new_features.newCreate')
    ->names([
        'index' => 'user_new_features.newIndex',
        'show' => 'user_new_features.newShow',
    ])
    /* We know that the parameter of the resource be singular from the resource URL plural name and you can change the parameter name using `paramter` */
    ->parameter('user_new_features', 'new_parameter_name')
    ->parameters([
        'user_new_feature' => 'user_feature',
    ])
    /* `scoped` method used to specify that segement name `user_feature` -we use `user_feature` becuase we have changed the parameter name using `parameters` method-, will be returned with an `email` instead of `id` */
    ->scoped([
        'user_feature' => 'email',
    ]);

/* Often, it is not entirely necessary to have both the parent and the child IDs within a URI since the child ID is already a unique identifier. When using unique identifiers such as auto-incrementing primary keys to identify your models in URI segments, you may choose to use "shallow nesting" So, here we must specify the parent(post) ID in `index`, `create`, and `store` to specify that comment must belongs to that post -in case of `create`, and `store`- but in case of updating or deleting we need not to specify the post ID because the comment ID is a unique identifier */
// Route::resource('posts.comments', Dashboard\CommentController::class)->shallow();

Route::get('newRequest/{name?}', function ($name = 'null') {
    /* `has` method used to check if the request this input name, `hasAny` used to check if the request any key from the passed arrays of keys, `missing` used to check if the request missing the given input name, `whenHas` used to exceute a closure in case of the request has the input key, `whenFilled` used to execute a closure if the request has the input name with a value */
    if (request()->has('name')) {
        echo "your name is {$name} using `has` function";
    } elseif (request()->filled('name')) {
        echo "the name key is exists with a value {$name} using `filled` function";
    } elseif (request()->hasAny(['id', 'name'])) {
        echo "the id or name is exists in your request";
    } elseif (request()->missing('name')) {
        echo "the name is missing from your request";
    }

    request()->whenHas('name', function ($name) {
        echo "your name is {$name} using `whenHas` function";
    });

    request()->whenFilled('name', function ($name) {
        echo "the name is filled and your name is {$name} using `whenFilled` function";
    });
});

Route::redirect('from', 'to', 301);

// The below line is equivalent to the upper one
Route::permanentRedirect('from', 'to');

Route::get('update-multi-users', function () {
    // instead of looping through all users using `for` or `foreach` you can use `toQuery` method
    \App\Models\User::get()->toQuery()->update([
        'name' => 'Updated!'
    ]);
});
