<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class PipelineQueryController extends Controller
{
    /* `pipeline` as a defination NOT exists in Laravel BUT Laravel use it in `app\Kernel` and from its name we can guess that there a pipe gives another pipe something */
    public function searchQuery()
    {
        /* `query` method allows us to create a query builder */
        $pipeline = app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\Pipelines\ProductFilter::class,
                \App\Pipelines\OrderFilter::class,
            ])
            ->thenReturn()
            ->get();

        return $pipeline;
    }
}
