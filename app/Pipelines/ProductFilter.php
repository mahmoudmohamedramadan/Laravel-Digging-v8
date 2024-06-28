<?php

namespace App\Pipelines;

use Closure;

class ProductFilter
{
    public function handle($request, Closure $next)
    {
        /* NOTE: The `$request` from type `QueryBuilder` that its value `User::query` which we send through `send` method */
        if (request()->query('product_id') == null) {
            // The below line takes the `$request` to the next pipe (OrderFilter)
            return $next($request);
        }

        return $next($request)->where('product_id', request()->query('product_id'));
    }
}
