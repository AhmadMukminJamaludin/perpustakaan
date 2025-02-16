<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenagihanDenda extends Model
{
    use HasFactory;

    protected $table = 'penagihan_denda';

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'order_id',
        'gross_amount',
        'snap_token',
        'payment_status',
        'payment_method',
        'payment_date',
    ];

    // Casting data untuk format yang lebih tepat
    protected $casts = [
        'gross_amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_id) {
                $model->order_id = self::generateOrderId();
            }
        });
    }

    /**
     * Fungsi untuk menghasilkan order_id dengan format invoice.
     * Contoh format: DENDA/20230415/123456
     */
    public static function generateOrderId()
    {
        $date = date('Ymd'); // Format tanggal: YYYYMMDD
        $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        return "DENDA/{$date}/{$randomNumber}";
    }

    /**
     * Relasi ke model Peminjaman.
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
