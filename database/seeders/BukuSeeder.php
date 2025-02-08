<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Buku;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $kategori = Kategori::create([
            'id' => Str::uuid(),
            'nama' => 'Teknologi',
            'deskripsi' => 'Buku tentang teknologi dan pemrograman.'
        ]);

        $penulis = Penulis::create([
            'id' => Str::uuid(),
            'nama' => 'John Doe',
            'email' => 'johndoe@example.com',
            'telepon' => '081234567890',
            'bio' => 'Penulis buku teknologi terkenal.'
        ]);

        $penerbit = Penerbit::create([
            'id' => Str::uuid(),
            'nama' => 'Tech Publishing',
            'email' => 'contact@techpublishing.com',
            'telepon' => '0211234567',
            'alamat' => 'Jl. Teknologi No. 123'
        ]);

        Buku::create([
            'id' => Str::uuid(),
            'isbn' => '9781234567890',
            'judul' => 'Pemrograman Laravel',
            'kategori_id' => $kategori->id,
            'penulis_id' => $penulis->id,
            'penerbit_id' => $penerbit->id,
            'tahun_terbit' => 2024,
            'stok' => 100,
            'harga' => 150000
        ]);
    }
}
