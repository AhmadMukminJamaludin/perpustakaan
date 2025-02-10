<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $jumlahBuku = Buku::all()->count();
        $jumlahAnggota = User::role('pengunjung')->get()->count();
        $totalDipinjam = Peminjaman::where(function($query) {
            $query->where('status', '!=', 'dikembalikan')->where('status', 'dipinjam');
        })->count();
        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $totalOverdue = Peminjaman::where('status', '!=', 'dikembalikan')
            ->where('tanggal_kembali', '<', Carbon::now())
            ->count();

        $peminjamanPerBulan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', Carbon::now()->year)
            ->where('status', 'dipinjam')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataBulan = array_fill(1, 12, 0); // Isi semua bulan dengan 0
            foreach ($peminjamanPerBulan as $bulan => $total) {
                $dataBulan[$bulan] = $total;
            }

        $bukuTerpopuler = Peminjaman::selectRaw('buku_id, COUNT(*) as total_peminjaman')
            ->groupBy('buku_id')
            ->orderByDesc('total_peminjaman')
            ->limit(5)
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($bukuTerpopuler as $item) {
            $buku = Buku::find($item->buku_id);
            $labels[] = $buku->judul ?? 'Tidak Diketahui';
            $data[] = $item->total_peminjaman;
            $colors[] = '#' . substr(md5(rand()), 0, 6); // Warna random
        }
        return view('dashboard.admin', [
            'jumlahBuku' => $jumlahBuku,
            'jumlahAnggota' => $jumlahAnggota,
            'totalDipinjam' => $totalDipinjam,
            'totalOverdue' => $totalOverdue,
            'peminjamanPerBulan' => array_values($dataBulan),
            'labels' => $labels, 
            'data' => $data, 
            'colors' => $colors
        ]);
    }

    public function pengunjung()
    {
        return view('dashboard.pengunjung');
    }
}
