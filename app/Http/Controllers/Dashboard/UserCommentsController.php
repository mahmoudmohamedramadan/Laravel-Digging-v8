<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{User, Comment};
use App\Http\Controllers\Controller;

class UserCommentsController extends Controller
{
    /**
     * Show the commect for the given user id
     *
     * @param  \App\models\User  $user
     * @param  \App\models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Comment $comment)
    {
        return $user->comments->find($comment->id);
    }
}
