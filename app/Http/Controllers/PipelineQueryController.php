<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class PipelineQueryController extends Controller
{
    /* `pipeline` as a definition not exists in Laravel but Laravel use it in `app\Kernel` and from its name we can guess that there a pipe gives another pipe something */

    /**
     * Filter the coming request data.
     *
     * @return mixed
     */
    public function searchQuery()
    {
        // `query` method allows us to create a query builder
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
