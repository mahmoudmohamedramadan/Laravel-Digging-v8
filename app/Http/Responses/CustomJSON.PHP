<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class CustomJSON implements Responsable
{
    // To declare a variable you can write the access modifier followed by with the variable name
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
