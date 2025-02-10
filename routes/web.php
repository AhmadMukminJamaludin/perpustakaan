<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'addToCart'])
    ->middleware('auth.booking')
    ->name('cart.add');
Route::get('/cart/view', [\App\Http\Controllers\CartController::class, 'viewCart'])->name('cart.view');
Route::get('/cart/count', [\App\Http\Controllers\CartController::class, 'cartCount'])->name('cart.count');
Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');

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

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/peminjaman/store', [\App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');

    Route::prefix('master')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::put('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.updateRole');
        Route::resource('buku', \App\Http\Controllers\Master\BukuController::class);
        Route::resource('kategori', \App\Http\Controllers\Master\KategoriController::class);
        Route::resource('penerbit', \App\Http\Controllers\Master\PenerbitController::class);
        Route::resource('penulis', \App\Http\Controllers\Master\PenulisController::class)->parameters(['penulis' => 'penulis']);
    });    

    Route::prefix('transaksi')->group(function () {
        Route::get('/booking', [\App\Http\Controllers\Transaksi\BookingController::class, 'index'])->name('booking.index');
        Route::get('/peminjaman', [\App\Http\Controllers\Transaksi\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/verifikasi', [\App\Http\Controllers\Transaksi\PeminjamanController::class, 'verifikasiPeminjaman'])->name('peminjaman.verifikasi');
        Route::post('/peminjaman/{id}/update', [\App\Http\Controllers\Transaksi\PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::post('/peminjaman/kembalikan', [\App\Http\Controllers\Transaksi\PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });
});

require __DIR__.'/auth.php';
