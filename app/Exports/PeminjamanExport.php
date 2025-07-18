<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeminjamanExport implements FromView
{
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function view(): View
    {
        $query = Peminjaman::with(['user', 'buku.penulis']);

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        $peminjamanList = $query->latest()->get();

        return view('laporan.peminjaman.export', [
            'peminjamanList' => $peminjamanList
        ]);
    }
}
