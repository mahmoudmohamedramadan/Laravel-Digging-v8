<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storage\SessionController;

Route::get('sessionView', [SessionController::class, 'index']);
