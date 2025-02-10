<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'buku';
    protected $fillable = [
        'isbn', 'judul', 'kategori_id', 'penulis_id', 
        'penerbit_id', 'tahun_terbit', 'stok', 'path'
    ];

    protected $appends = ['sisa_stok', 'jumlah_dipinjam'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function getSisaStokAttribute()
    {
        $bukuDipinjam = $this->peminjaman()
            ->whereNull('tanggal_dikembalikan') // Buku yang belum dikembalikan
            ->count();

        return max(0, $this->stok - $bukuDipinjam); // Sisa stok tidak boleh negatif
    }

    public function getJumlahDipinjamAttribute()
    {
        return $this->peminjaman()
            ->whereNull('tanggal_dikembalikan') // Hanya yang belum dikembalikan
            ->count();
    }
}
