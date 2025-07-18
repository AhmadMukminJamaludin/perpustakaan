<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Exports\PeminjamanExport;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    public function index()
    {
        $query = Peminjaman::with(['user', 'buku.penulis']);

        if (auth()->user()->hasRole('pengunjung')) {
            $query->where('user_id', auth()->id());
        }

        $peminjamanList = $query->latest()->get();
        return view('laporan.peminjaman.index', compact('peminjamanList'));
    }

    public function exportExcel(Request $request)
    {
        $userId = auth()->user()->hasRole('pengunjung') ? auth()->id() : null;
        return Excel::download(new PeminjamanExport($userId), 'laporan-peminjaman.xlsx');
    }

    public function printPdf()
    {
        $query = Peminjaman::with(['user', 'buku.penulis']);
        if (auth()->user()->hasRole('pengunjung')) {
            $query->where('user_id', auth()->id());
        }
        $peminjamanList = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.peminjaman.print', compact('peminjamanList'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-peminjaman.pdf');
    }
}
