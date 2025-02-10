<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::paginate(10);
        return view('master.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.kategori.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama'      => 'required|string|max:255',
                'deskripsi' => 'nullable|string'
            ]);
            // Simpan kategori baru menggunakan mass assignment
            Kategori::create($validated);
            return redirect()->route('kategori.index')
                             ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Gagal menambahkan kategori: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menambahkan kategori.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('master.kategori.form', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        try {
            $validated = $request->validate([
                'nama'      => 'required|string|max:255|unique:kategori,nama,' . $kategori->id . ',id',
                'deskripsi' => 'nullable|string'
            ]);
            // Perbarui data kategori menggunakan mass assignment
            $kategori->update($validated);
            return redirect()->route('kategori.index')
                             ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui kategori: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        try {
            if ($kategori->buku()->exists()) {
                return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena sudah memiliki buku terkait.');
            }
            $kategori->delete();
            return redirect()->route('kategori.index')
                            ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus kategori: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

}
