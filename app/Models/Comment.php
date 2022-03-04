<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* Use this method if you want to make a `route model binding`, NOTE that to make `resolveRouteBinding` working you must bind the segment key with the `Comment` model using `model` method in `RouteServiceProvider` */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->find($value);
    }

    /* NOTE that always we add the id of the parent table in the child table as `{parentTableSingularName}_{id}` */
    public function user()
    {
        /* `withDefault` function will return its closure data in case of there is no user for a specific comment, NOTE that in `belongsTo` relationship we have added the foreign key of the related table in this model like `user_id` */
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(function($user, $comment) {
            $user->id = '0';
            $user->name = 'NULL';
            $user->email = 'NULL@NULL.com';
            $comment->body = 'NULL';
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id', 'comments');
    }

    /* In case you accept `$q` only you have not passed anything when you call `scopedComments` but when you accept some parameters after `$q` you should pass them, NOTE that you can call scope in studly case or camel case */
    public function scopeScopedComments($q, $post_id, $user_id)
    {
        $q->where('post_id', '>', $post_id)->where('user_id', '>', $user_id);
    }
}
