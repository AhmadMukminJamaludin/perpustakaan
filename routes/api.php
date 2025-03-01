<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendefinisikan route API untuk aplikasi Anda. Semua
| route di file ini secara otomatis akan memiliki prefix /api.
|
*/

Route::middleware('api')->group(function () {
    Route::get('/books', [\App\Http\Controllers\Api\BukuController::class, 'index']);
    Route::get('/categories', [\App\Http\Controllers\Api\BukuController::class, 'categories']);
});
