<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request) 
    {
        $query = \App\Models\Buku::with(['penulis', 'penerbit'])
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count');
        
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where('judul', 'like', "%{$keyword}%")
                ->orWhereHas('penulis', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });
        }

        if ($request->has('categories') && !empty($request->categories)) {
            $category = explode(',', $request->categories);
            
            $query->whereIn('kategori_id', $category);
        }

        $bukuList = $query->paginate(9)->appends($request->all());

        return response()->json($bukuList);
    }

    public function categories()
    {
        return response()->json(Kategori::all());
    }
}
