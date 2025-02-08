<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

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
    Route::get('/books', [BukuController::class, 'index']);
});
