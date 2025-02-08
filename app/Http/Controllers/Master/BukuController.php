<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with(['kategori', 'penulis', 'penerbit'])->get();
        return view('master.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('master.buku.form', [
            'penulis' => Penulis::all(),
            'penerbit' => Penerbit::all(),
            'kategori' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'isbn'         => 'required|string|unique:buku,isbn',
                'judul'        => 'required|string|max:255',
                'kategori_id'  => 'required|exists:kategori,id',
                'penulis_id'   => 'required|exists:penulis,id',
                'penerbit_id'  => 'required|exists:penerbit,id',
                'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
                'harga'        => 'required|numeric|min:0'
            ]);
            // Simpan data buku dengan mass assignment
            Buku::create($validated);
            return redirect()->route('buku.index')
                            ->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Log error untuk keperluan debugging
            \Log::error('Gagal menambahkan buku: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat menambahkan buku.');
        }
    }


    public function edit(Buku $buku)
    {
        return view('master.buku.form', [
            'buku' => $buku,
            'penulis' => Penulis::all(),
            'penerbit' => Penerbit::all(),
            'kategori' => Kategori::all()
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        try {
            $validated = $request->validate([
                'isbn'         => 'required|string',
                'judul'        => 'required|string|max:255',
                'kategori_id'  => 'required|exists:kategori,id',
                'penulis_id'   => 'required|exists:penulis,id',
                'penerbit_id'  => 'required|exists:penerbit,id',
                'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
                'harga'        => 'required|numeric|min:0'
            ]);
            // Perbarui data buku dengan mass assignment
            $buku->update($validated);
    
            return redirect()->route('buku.index')
                             ->with('success', 'Buku berhasil diperbarui.');
        } catch (\Exception $e) {
            // Catat error untuk keperluan debugging
            \Log::error('Gagal memperbarui buku: ' . $e->getMessage());
    
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui buku.');
        }
    }
    

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Cegah penghapusan jika ada kondisi tertentu (misalnya buku sedang dipinjam)
        if ($buku->dipinjam) {
            return redirect()->route('buku.index')->with('error', 'Buku ini sedang dipinjam dan tidak bisa dihapus.');
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
