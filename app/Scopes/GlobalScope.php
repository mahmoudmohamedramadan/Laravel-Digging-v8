<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\{Model, Scope, Builder};

class GlobalScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // return $builder->where('id', '>', 5);
    }
}
