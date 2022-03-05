<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PipelineQueryController, QueryBuilderController};

Route::get('query', [QueryBuilderController::class, 'index']);

Route::get('pipelineQuery', [PipelineQueryController::class, 'searchQuery']);
