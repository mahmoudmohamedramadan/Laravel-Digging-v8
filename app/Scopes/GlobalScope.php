<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\{Model, Scope, Builder};

class GlobalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // return $builder->where('id', '>', 5);
    }
}
