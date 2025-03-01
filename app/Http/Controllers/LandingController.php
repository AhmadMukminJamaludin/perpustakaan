<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(Request $request) 
    {
        $query = \App\Models\Buku::with(['penulis', 'penerbit'])
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count');
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                ->orWhereHas('penulis', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        }

        $bukuList = $query->paginate(9)->appends($request->all());

        $bukuDipinjam = [];
        if (Auth::check()) {
            $bukuDipinjam = Peminjaman::where('user_id', Auth::id())
                ->where('status', '<>', 'dikembalikan')
                ->pluck('buku_id')
                ->toArray();
        }

        $maxPeminjaman = $bukuList->max('peminjaman_count');

        return view('landing', compact('bukuList', 'bukuDipinjam', 'maxPeminjaman'));
    }
}
