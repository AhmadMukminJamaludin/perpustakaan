<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request) 
    {
        $query = \App\Models\Buku::with(['penulis', 'penerbit']);
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                ->orWhereHas('penulis', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        }

        $bukuList = $query->paginate(9)->appends($request->all());

        $bukuDipinjam = \App\Models\Peminjaman::where('status', '<>', 'Dikembalikan')
            ->pluck('buku_id')
            ->toArray();

        return view('landing', compact('bukuList', 'bukuDipinjam'));
    }
}
