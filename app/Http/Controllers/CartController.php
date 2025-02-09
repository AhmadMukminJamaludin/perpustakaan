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
    public function viewCart()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User belum login'], 401);
        }

        // Ambil daftar buku dari tabel keranjang berdasarkan user_id
        $cartItems = Keranjang::where('user_id', $user->id)
            ->with('buku.penulis') // Ambil relasi buku dan penulis
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->buku->id,
                    'judul' => $item->buku->judul,
                    'penulis' => $item->buku->penulis->nama ?? 'Tidak Diketahui',
                    'sampul' => $item->buku->path
                        ? asset('storage/' . $item->buku->path)
                        : 'https://placehold.jp/200x300.png', 
                ];
            });

        return response()->json(['cart_items' => $cartItems]);
    }

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

    public function removeFromCart(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User belum login'], 401);
        }

        $bukuId = $request->input('buku_id');

        // Hapus item dari database
        $deleted = Keranjang::where('user_id', $user->id)
            ->where('buku_id', $bukuId)
            ->delete();

        if ($deleted) {
            // Hitung ulang jumlah item dalam cart
            $cartCount = Keranjang::where('user_id', $user->id)->count();

            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);
        }

        return response()->json(['success' => false]);
    }

}
