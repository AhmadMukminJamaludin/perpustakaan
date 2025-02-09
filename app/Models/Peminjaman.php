<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
    ];

    protected $dates = ['tanggal_pinjam', 'tanggal_kembali', 'tanggal_dikembalikan'];

    protected $appends = ['total_denda', 'lama_pinjaman', 'lama_keterlambatan'];

    /**
     * Menghitung total denda berdasarkan keterlambatan.
     * Denda hanya dihitung jika status belum "Dikembalikan".
     */
    public function getTotalDendaAttribute()
    {
        $hariTerlambat = $this->lama_keterlambatan; 

        // Jika keterlambatan berupa angka, hitung denda
        return is_numeric($hariTerlambat) ? $hariTerlambat * $this->denda : 0;
    }


    // Attribute Lama Pinjaman (Jumlah Hari dari Pinjam ke Kembali)
    public function getLamaPinjamanAttribute()
    {
        if (!$this->tanggal_pinjam) {
            return '-';
        }
    
        $tanggalPinjam = \Carbon\Carbon::parse($this->tanggal_pinjam);
        $tanggalKembali = $this->tanggal_dikembalikan 
            ? \Carbon\Carbon::parse($this->tanggal_dikembalikan)->startOfDay() 
            : now()->startOfDay(); // Jika tanggal_dikembalikan null, gunakan tanggal sekarang
    
        return $tanggalPinjam->diffInDays($tanggalKembali);
    }

    // Attribute Lama Keterlambatan
    public function getLamaKeterlambatanAttribute()
    {
        // Jika tanggal_kembali (jatuh tempo) NULL, anggap tidak ada keterlambatan
        if (!$this->tanggal_kembali) {
            return '-';
        }
    
        $tanggalJatuhTempo = \Carbon\Carbon::parse($this->tanggal_kembali)->startOfDay();
    
        // Jika sudah dikembalikan, hitung dari tanggal dikembalikan
        if ($this->status === 'dikembalikan' && $this->tanggal_dikembalikan) {
            $tanggalDikembalikan = \Carbon\Carbon::parse($this->tanggal_dikembalikan)->startOfDay();
            $hariTerlambat = $tanggalJatuhTempo->diffInDays($tanggalDikembalikan, false);
        } else {
            // Jika belum dikembalikan, hitung dari hari ini
            $hariTerlambat = $tanggalJatuhTempo->diffInDays(\Carbon\Carbon::now()->startOfDay(), false);
        }
    
        return $hariTerlambat > 0 ? $hariTerlambat : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
