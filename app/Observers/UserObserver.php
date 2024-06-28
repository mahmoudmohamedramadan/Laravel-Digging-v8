<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // Do something here that wil be triggered when the user is created
        // NOTE: The `$user` parameter refers to the user that we've created
        // dd("{$user->name} is created successfully!");
    }
}
