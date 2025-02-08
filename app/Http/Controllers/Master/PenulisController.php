<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    /**
     * Menampilkan daftar penulis.
     */
    public function index()
    {
        $penulis = Penulis::paginate(10);
        return view('master.penulis.index', compact('penulis'));
    }

    /**
     * Menampilkan form untuk membuat penulis baru.
     */
    public function create()
    {
        return view('master.penulis.form');
    }

    /**
     * Menyimpan data penulis baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255|unique:penulis,nama',
            'email'    => 'nullable|email|unique:penulis,email',
            'telepon'  => 'nullable|string|max:20',
            'bio'      => 'nullable|string',
        ]);

        try {
            Penulis::create($validated);
            return redirect()->route('penulis.index')
                             ->with('success', 'Penulis berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Gagal menambahkan penulis: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menambahkan penulis.');
        }
    }

    /**
     * Menampilkan form untuk mengedit data penulis.
     */
    public function edit(Penulis $penulis)
    {
        return view('master.penulis.form', compact('penulis'));
    }

    /**
     * Memperbarui data penulis yang sudah ada.
     */
    public function update(Request $request, Penulis $penulis)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255|unique:penulis,nama,' . $penulis->id,
            'email'    => 'nullable|email|unique:penulis,email,' . $penulis->id,
            'telepon'  => 'nullable|string|max:20',
            'bio'      => 'nullable|string',
        ]);

        try {
            $penulis->update($validated);
            return redirect()->route('penulis.index')
                             ->with('success', 'Penulis berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui penulis: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui penulis.');
        }
    }

    /**
     * Menghapus data penulis dari database.
     * Jika penulis sudah memiliki relasi dengan buku, proses penghapusan tidak diizinkan.
     */
    public function destroy(Penulis $penulis)
    {
        // Misalnya, jika relasi penulis ke buku sudah didefinisikan dengan method buku()
        if ($penulis->buku()->exists()) {
            return redirect()->back()
                             ->with('error', 'Penulis tidak dapat dihapus karena sudah memiliki relasi dengan buku.');
        }

        try {
            $penulis->delete();
            return redirect()->route('penulis.index')
                             ->with('success', 'Penulis berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus penulis: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menghapus penulis.');
        }
    }
}
