<?php

namespace App\Pipelines;

use Closure;

class OrderFilter
{
    public function handle($request, Closure $next)
    {
        // check if the `order_by` value not exists in passed array
        if (!key_exists(request()->query('order_by'), ['asc', 'desc'])) {
            return $next($request);
        }

        return $next($request)->orderBy('name', request()->query('order_by'));
    }
}
