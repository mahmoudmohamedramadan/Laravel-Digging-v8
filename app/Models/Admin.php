<?php

namespace App\Models;

use App\Traits\CheckAuthenticatedUser;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Admin extends Model
{
    /* Each method in `CheckAuthenticatedUser` trait and its name was `boot{TraitName}` will be auto-called as a `boot` */
    use HasFactory, CheckAuthenticatedUser;

    protected $guarded = [];

    /* the way of using trait's method is equal to this method */
    protected static function boot()
    {
        parent::boot();

        if (auth()->id() == 1) {
            self::creating(function ($model) {
                $model->created_at = now();
            });
        }
    }
}
