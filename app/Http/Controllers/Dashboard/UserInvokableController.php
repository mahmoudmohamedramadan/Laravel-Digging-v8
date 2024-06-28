<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class UserInvokableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return 'Welcome from `__invokable` Controller';
    }
}
