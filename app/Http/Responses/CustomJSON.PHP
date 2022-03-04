<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class CustomJSON implements Responsable
{
    /* here is the new way to declare a variable */
    public function __construct(private $users)
    {
        $this->users = $users;
    }

    public function toResponse($request)
    {
        return response(json_encode($this->users))
            ->withHeaders(['Content-Type' => 'application/json']);
    }
}
