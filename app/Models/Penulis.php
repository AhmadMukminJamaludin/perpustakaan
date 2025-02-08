<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penulis extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'penulis';
    protected $fillable = ['nama', 'email', 'telepon', 'bio'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'penulis_id');
    }
}
