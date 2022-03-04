<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StudentFacade extends Facade
{
    /* The `Facades` defination is NOT related to Laravel ONLY BUT it is a design pattern, that allows the user to deal with the classes through the facade... for more info https://shishirthedev.medium.com/facade-in-laravel-application-d2a3053f5a71 */
    protected static function getFacadeAccessor()
    {
        return 'student';
    }
}
