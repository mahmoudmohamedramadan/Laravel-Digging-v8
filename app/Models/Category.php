<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* If you need to customize the names of the columns used to store the timestamps, you may define `CREATED_AT` and `UPDATED_AT` constants on your model */
    // const CREATED_AT = 'creation_at';
    // const UPDATED_AT = 'updated_at';

    /* By default, Eloquent expects `created_at` and `updated_at` columns to exist on your model's corresponding database table. Eloquent will automatically set these column's values when models are created or updated. If you do not want these columns to be automatically managed by Eloquent, you should define a `$timestamps` property on your model with a value of false */
    // public $timestamps = false;

    /* By default, a newly instantiated model instance will not contain any attribute values. If you would like to define the default values for some of your model's attributes, you may define an `$attributes` property on your model */
    protected $attributes = [
        'title' => 'Test Category',
    ];
}
