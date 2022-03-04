<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storage\StorageController;

Route::view('storageUpload', 'storage.create');

Route::get('storagePutManualFiles', [StorageController::class, 'storagePutManualFiles']);
Route::post('storagePutUploadedFiles', [StorageController::class, 'storagePutUploadedFiles']);
Route::post('storageUpdatePicture', [StorageController::class, 'updatePicture']);
Route::post('storageDownloadFile', [StorageController::class, 'downloadImageFile']);
