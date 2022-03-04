<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;

Route::get('globalArray', [GlobalController::class, 'diveIntoArray']);
Route::get('globalURL', [GlobalController::class, 'diveIntoURL']);
Route::get('globalapplicationPATHS', [GlobalController::class, 'applicationPATHS']);
Route::get('globalMiscellaneous', [GlobalController::class, 'Miscellaneous']);
