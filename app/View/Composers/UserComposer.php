<?php

namespace App\View\Composers;

use App\Models\User;

class UserComposer
{
    public function compose($view)
    {
        $view->with('users', User::get());
    }
}
