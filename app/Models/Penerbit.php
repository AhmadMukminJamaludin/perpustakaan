<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerbit extends Model
{
    use HasUuids;

    protected $table = 'penerbit';
    protected $fillable = ['nama', 'email', 'telepon', 'alamat'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
}
