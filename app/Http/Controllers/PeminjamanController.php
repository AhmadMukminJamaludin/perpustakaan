<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'buku_ids' => 'required|array|min:1', // buku_ids harus array dengan minimal 1 item
            'buku_ids.*' => 'uuid|exists:buku,id', // Setiap elemen buku_ids harus UUID valid dan ada di tabel buku
            'tanggal_pinjam' => 'required|date|after_or_equal:today', // Tanggal pinjam harus valid dan >= hari ini
        ]);

        // Mendapatkan user yang login
        $user = Auth::user();

        // Periksa apakah user sudah login
        if (!$user) {
            return response()->json([
                'message' => 'Silakan login terlebih dahulu untuk melakukan peminjaman.'
            ], 401);
        }

        // Proses data peminjaman
        try {
            foreach ($validated['buku_ids'] as $bukuId) {
                Peminjaman::create([
                    'user_id' => $user->id,
                    'buku_id' => $bukuId,
                    'tanggal_pinjam' => $validated['tanggal_pinjam'],
                ]);

                Keranjang::where('user_id', $user->id)
                    ->where('buku_id', $bukuId)
                    ->delete();
            }

            return response()->json([
                'message' => 'Peminjaman berhasil diproses.',
                'cart_count' => 0, // Kosongkan cart count setelah peminjaman
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses peminjaman.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function getOverduePeminjaman(Request $request)
    {
        $query = Peminjaman::with(['user:id,name', 'buku:id,judul'])
            ->where('status', '<>', 'Dikembalikan')
            ->whereDate('tanggal_kembali', '<', Carbon::today());

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('buku', function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%");
                });
            });
        }

        $overduePeminjaman = $query->orderBy('tanggal_kembali', 'asc')
            ->get()
            ->map(function ($item) {
                $item->formatted_tanggal_kembali = Carbon::parse($item->tanggal_kembali)->translatedFormat('d F Y');
                return $item;
            });

        return response()->json($overduePeminjaman);
    }
}
