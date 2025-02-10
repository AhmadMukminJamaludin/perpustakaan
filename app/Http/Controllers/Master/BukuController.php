<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                'isbn'         => [
                    'required',
                    'string',
                    Rule::unique('buku', 'isbn')->whereNull('deleted_at'),
                ],
                'judul'        => 'required|string|max:255',
                'kategori_id'  => 'required|exists:kategori,id',
                'penulis_id'   => 'required|exists:penulis,id',
                'penerbit_id'  => 'required|exists:penerbit,id',
                'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
                'sampul'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'stok'       => 'required',
            ]);

            $filePath = null;
            if ($request->hasFile('sampul')) {
                $file = $request->file('sampul');
                $filePath = $file->store('sampul_buku', 'public');
            }
            $data = array_merge($validated, ['path' => $filePath]);
            Buku::create($data);
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
                'isbn'         => [
                    'required',
                    'string',
                    Rule::unique('buku', 'isbn')
                        ->ignore($buku->id)
                        ->whereNull('deleted_at'),
                ],
                'judul'        => 'required|string|max:255',
                'kategori_id'  => 'required|exists:kategori,id',
                'penulis_id'   => 'required|exists:penulis,id',
                'penerbit_id'  => 'required|exists:penerbit,id',
                'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
                'sampul'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'stok'       => 'required',
            ]);

            if ($request->hasFile('sampul')) {
                $file = $request->file('sampul');
                $newPath = $file->store('sampul_buku', 'public');
        
                if ($buku->path && Storage::disk('public')->exists($buku->path)) {
                    Storage::disk('public')->delete($buku->path);
                }
        
                $validated['path'] = $newPath;
            }

            $buku->update($validated);
    
            return redirect()->route('buku.index')
                             ->with('success', 'Buku berhasil diperbarui.');
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Sudah ada ISBN buku dengan nomor: ' . request('isbn'));
            }
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
        
        if ($buku->path && Storage::disk('public')->exists($buku->path)) {
            Storage::disk('public')->delete($buku->path);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
