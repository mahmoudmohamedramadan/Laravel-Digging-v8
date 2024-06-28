<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class PipelineQueryController extends Controller
{
    /* `pipeline` as a definition does not exist in the Laravel documentation but Laravel uses it under the hood */
    // NOTE: Laravel recently added the `pipeline` in its documentation

    /**
     * Filter the coming request data.
     *
     * @return mixed
     */
    public function searchQuery()
    {
        // The `query` method allows us to create a query builder
        return app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\Pipelines\ProductFilter::class,
                \App\Pipelines\OrderFilter::class,
            ])
            ->thenReturn()
            ->get();
    }
}
