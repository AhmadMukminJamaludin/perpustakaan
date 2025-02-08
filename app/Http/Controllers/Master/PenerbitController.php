<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerbit = Penerbit::paginate(10);
        return view('master.penerbit.index', compact('penerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.penerbit.form');
    }

    /**
     * Simpan data penerbit baru.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama'     => 'required|string|max:255|unique:penerbit,nama',
                'email'    => 'nullable|email|unique:penerbit,email',
                'telepon'  => 'nullable|string|max:20',
                'alamat'   => 'nullable|string'
            ]);
            // Simpan penerbit baru dengan mass assignment
            Penerbit::create($validated);
            return redirect()->route('penerbit.index')
                             ->with('success', 'Penerbit berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Gagal menambahkan penerbit: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menambahkan penerbit.');
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
    public function edit(Penerbit $penerbit)
    {
        return view('master.penerbit.form', compact('penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penerbit $penerbit)
    {
        // Validasi input, dengan pengecualian untuk nilai unik penerbit yang sedang diupdate
        $validated = $request->validate([
            'nama'     => 'required|string|max:255|unique:penerbit,nama,' . $penerbit->id . ',id',
            'email'    => 'nullable|email|unique:penerbit,email,' . $penerbit->id . ',id',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string'
        ]);

        try {
            // Perbarui data penerbit dengan mass assignment
            $penerbit->update($validated);
            return redirect()->route('penerbit.index')
                             ->with('success', 'Penerbit berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui penerbit: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui penerbit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penerbit $penerbit)
    {
        // Cek apakah penerbit sudah memiliki buku terkait
        if ($penerbit->buku()->exists()) {
            return redirect()->back()
                             ->with('error', 'Penerbit tidak dapat dihapus karena sudah terdapat relasi dengan buku.');
        }

        try {
            $penerbit->delete();
            return redirect()->route('penerbit.index')
                             ->with('success', 'Penerbit berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus penerbit: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menghapus penerbit.');
        }
    }
}
