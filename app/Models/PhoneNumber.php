<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
    ];

    /* `touches` property when you update any record from child model(PhoneNumber) the `updated_at` column in parent model(User) will be updated also */
    protected  $touches = ['user'];

    /* NOTE that always we add the id of child table in the parent table as `{parentTableSingularName}_{id} */
    public function user()
    {
        /* in `belongsTo` we add the foreign key of the related table like `user_id` */
        return $this->belongsTo(User::class, 'user_id', 'id', 'phone');
    }
}
