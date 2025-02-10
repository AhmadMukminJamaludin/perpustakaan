<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamanList = Peminjaman::with(['user', 'buku.penulis'])->latest()->get();
        return view('transaksi.peminjaman.index', compact('peminjamanList'));
    }

    public function verifikasiPeminjaman(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:peminjaman,id',
            'tanggal_kembali' => 'required|date',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->id);
        $peminjaman->tanggal_kembali = $request->tanggal_kembali;
        $peminjaman->status = 'dipinjam';
        $peminjaman->denda = $request->denda ?? 0;
        $peminjaman->save();

        return response()->json(['message' => 'Peminjaman berhasil diverifikasi.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:menunggu verifikasi,dipinjam,dikembalikan',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'denda' => $request->denda,
        ]);

        return response()->json(['message' => 'Peminjaman berhasil diperbarui']);
    }

    public function kembalikan(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:peminjaman,id',
            'tanggal_dikembalikan' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($validated['id']);

        $peminjaman->update([
            'tanggal_dikembalikan' => $validated['tanggal_dikembalikan'],
            'status' => 'dikembalikan'
        ]);

        return response()->json([
            'message' => 'Buku berhasil dikembalikan.',
        ]);
    }

}
