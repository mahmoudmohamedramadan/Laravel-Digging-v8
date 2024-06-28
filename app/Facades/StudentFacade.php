<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StudentFacade extends Facade
{
    /* The `Facade` definition is not related to Laravel only but it is a design pattern, that allows the user to deal with the classes through the facade */
    // For more info: https://shishirthedev.medium.com/facade-in-laravel-application-d2a3053f5a71

    protected static function getFacadeAccessor()
    {
        return 'student';
    }
}
