<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        /* `only` method allows you to specify the methods that you want to apply this middleware on them */
        // $this->middleware('auth')->only('methodName');

        /* `except` method allows you to specify the methods that you want to exclude them from this middleware */
        // $this->middleware('auth')->except('methodName');

        // You can also pass a closure for `middleware` method
        $this->middleware(function($request, $next) {
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
