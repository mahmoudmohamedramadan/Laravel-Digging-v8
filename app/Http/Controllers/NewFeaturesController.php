<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewFeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* The `retry` function attempts to execute the given callback until the given maximum attempt threshold is met. If the callback does not throw an exception, its return value will be returned. If the callback throws an exception, it will automatically be retried. If the maximum attempt count is exceeded, the exception will be thrown, NOTE that you can pass in the third paramter a closure  to manually calculate the number of milliseconds to sleep in between attempts and optionally pass a closure in the fourth parameter and accept the `$exception` */
        return retry(5, function () {
            // Attempt 5 times while resting 100ms in between attempts...
            return User::get();
        }, 100);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Welcome from create function';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* If ou want check something in the request, instead of using multiple `if` you can use any scenairo of these */

        /* First you can use switvh case */
        switch($request->url()) {
            case '/users/create': $model = '\\App\\Models\\User';
            case '/dogs/create': $model = '\\App\\Models\\Dog';
        }

        $model::create([
            // insert your data here...
        ]);

        /* Second is a new syntax in PHP */
        match($request->url()) {
            '/users/create' => '\\App\\Models\\User',
            '/dogs/create' => '\\App\\Models\\Dog',
        };

        /* For more info visit: https://www.stitcher.io/blog/php-8-match-or-switch */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
