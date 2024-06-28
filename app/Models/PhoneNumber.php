<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
    ];

    /* `touches` property will updates `updated_at` column of the child model (PhoneNumber) once the `updated_at` column in parent model(User) is updated */
    protected $touches = ['user'];

    public function user()
    {
        // In the `belongsTo` we add the foreign key of the related table like `user_id`
        return $this->belongsTo(User::class, 'user_id', 'id', 'phone');
    }
}
