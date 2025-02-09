<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckAuthForBooking;
use App\Models\Keranjang;
use App\Models\Buku;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $bukuId = $request->input('buku_id');
        $userId = Auth::id();

        // Cek apakah buku yang ditambahkan ada di database
        $buku = Buku::find($bukuId);
        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        // Cek apakah buku sudah ada di keranjang user
        $keranjang = Keranjang::where('user_id', $userId)
                            ->where('buku_id', $bukuId)
                            ->first();

        if ($keranjang) {
            return response()->json([
                'success' => false,
                'message' => 'Buku sudah ada di keranjang!',
            ], 400);
        }

        // Simpan ke database
        Keranjang::create([
            'user_id' => $userId,
            'buku_id' => $bukuId,
        ]);

        // Update session cart (opsional)
        $cart = Session::get('cart', []);
        if (!in_array($bukuId, $cart)) {
            $cart[] = $bukuId;
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan ke cart!',
            'cart_count' => $this->cartCountNumber(),
        ]);
    }

    public function cartCount()
    {
        return response()->json(['cart_count' => $this->cartCountNumber()]);
    }

    private function cartCountNumber()
    {
        return Auth::check() ? Keranjang::where('user_id', Auth::id())->count() : 0;
    }
}
