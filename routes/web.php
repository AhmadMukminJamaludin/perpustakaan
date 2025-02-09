<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'addToCart'])
    ->middleware('auth.booking')
    ->name('cart.add');
Route::get('/cart/count', [\App\Http\Controllers\CartController::class, 'cartCount'])->name('cart.count');

Route::get('/check-auth', function () {
    return response()->json(['authenticated' => Auth::check()]);
})->name('check.auth');

Route::post('/login-ajax', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
})->name('login.ajax');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('master')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::put('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.updateRole');
        Route::resource('buku', \App\Http\Controllers\Master\BukuController::class);
        Route::resource('kategori', \App\Http\Controllers\Master\KategoriController::class);
        Route::resource('penerbit', \App\Http\Controllers\Master\PenerbitController::class);
        Route::resource('penulis', \App\Http\Controllers\Master\PenulisController::class)->parameters(['penulis' => 'penulis']);
    });    
});

require __DIR__.'/auth.php';
