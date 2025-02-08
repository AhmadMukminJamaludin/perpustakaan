<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Buku;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Misal, kita ingin membuat 20 data buku
        for ($i = 0; $i < 20; $i++) {
            // Ambil data random dari kategori, penulis, dan penerbit
            $kategori = Kategori::inRandomOrder()->first();
            $penulis = Penulis::inRandomOrder()->first();
            $penerbit = Penerbit::inRandomOrder()->first();

            Buku::create([
                'isbn'         => $faker->unique()->isbn13,
                'judul'        => $faker->sentence(3),
                'kategori_id'  => $kategori ? $kategori->id : null,
                'penulis_id'   => $penulis ? $penulis->id : null,
                'penerbit_id'  => $penerbit ? $penerbit->id : null,
                'tahun_terbit' => $faker->numberBetween(1900, date('Y')),
                'stok'         => $faker->numberBetween(1, 100),
                // Karena belum ada unggahan sampul, bisa disimpan null atau gunakan placeholder.
                'path'         => null,
            ]);
        }
    }
}
