<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $query = Peminjaman::with(['user', 'buku.penulis']);

        if (auth()->user()->hasRole('pengunjung')) {
            $query->where('user_id', auth()->id());
        }

        $peminjamanList = $query->latest()->get();
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

    public function updateStatusHilang(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'denda_kehilangan' => 'required|numeric|min:0',
            'alasan' => 'required|string|max:255',
        ]);
    
        try {
            Peminjaman::where('buku_id', $request->buku_id)
                ->where('status', 'Dipinjam')
                ->update([
                    'status' => 'hilang',
                    'denda_kehilangan' => $request->denda_kehilangan,
                    'keterangan_kehilangan' => $request->alasan,
                ]);
    
            return response()->json(['message' => 'Laporan berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function batalHilang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'dipinjam',
            'denda_kehilangan' => 0,
            'keterangan_kehilangan' => "",
        ]);

        return response()->json(['message' => 'Laporan hilang berhasil dibatalkan.']);
    }
}
