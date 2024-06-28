<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* The foreign key value represents the column in the current model that refer/belongs to the second model like `user_id` exists in this model [`Post`] and refer/belongs to the other model [`User`] */
    public function user()
    {
        /* The `withDefault` method will return its array in case of there is no user for a specific post */
        return $this->belongsTo(User::class, 'user_id', 'id', 'posts')->withDefault([
            'id' => '0',
            'name' => 'NULL',
            'email' => 'NULL@NULL.com',
        ]);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id', 'post');
    }

    /* When you are reading the data, you can change how particular column output */
    public function getBodyAttribute($value)
    {
        return "Accessor {$value}";
    }

    // You can use an accessor when a column not exists in the database
    public function getUserWithBodyAttribute()
    {
        return "{$this->name} {$this->email}";
    }
}
