<?php

namespace App\View\Composers;

use App\Models\User;

class UserComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose($view)
    {
        $view->with('users', User::get());
    }
}
