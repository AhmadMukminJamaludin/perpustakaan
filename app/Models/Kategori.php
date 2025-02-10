<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasUuids;

    protected $table = 'kategori'; // Nama tabel di database
    protected $fillable = ['nama', 'deskripsi'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
