<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dump('welcome from api index');
    }
}
