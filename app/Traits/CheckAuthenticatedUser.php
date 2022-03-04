<?php

namespace App\Traits;

trait CheckAuthenticatedUser
{
    /* a new feature in Laravel that each method name was `boot{TraitName}` it will be auto-called as a `boot` */
    public static function bootCheckAuthenticatedUser()
    {
        static::creating(function($model) {
            if(auth()->id() == 1) {
                $model->created_at = now();
            }
        });
    }
}
