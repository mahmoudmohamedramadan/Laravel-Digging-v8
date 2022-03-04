<?php

namespace App\Pipelines;

use Closure;

class ProductFilter
{
    public function handle($request, Closure $next)
    {
        /* NOTE that `$request` from type `QueryBuilder` that its value `User::query` which we send through `send` method */
        if (request()->query('product_id') == null) {
            /* this line takes the `$request` into the next pipe(OrderFilter) */
            return $next($request);
        }

        return $next($request)->where('product_id', request()->query('product_id'));
    }
}
