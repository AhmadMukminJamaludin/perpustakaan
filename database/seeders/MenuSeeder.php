<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menu')->insert([
            ['name' => 'Dashboard', 'slug' => Str::slug('Dashboard'), 'level' => 1, 'parent_id' => null, 'url' => '/dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['name' => 'Profil', 'slug' => Str::slug('Profil'), 'level' => 1, 'parent_id' => null, 'url' => '/profile', 'icon' => 'fas fa-user'],
            ['name' => 'Koleksi Buku', 'slug' => Str::slug('Koleksi Buku'), 'level' => 1, 'parent_id' => null, 'url' => '/', 'icon' => 'fas fa-cart-shopping'],
            ['name' => 'Master Data', 'slug' => Str::slug('Master Data'), 'level' => 1, 'parent_id' => null, 'url' => null, 'icon' => 'fas fa-database'],
            ['name' => 'Pengguna', 'slug' => Str::slug('Pengguna'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/users', 'icon' => 'fas fa-users'],
            ['name' => 'Master Kategori', 'slug' => Str::slug('Master Kategori'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/kategori', 'icon' => 'fas fa-tags'],
            ['name' => 'Master Penerbit', 'slug' => Str::slug('Master Penerbit'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/penerbit', 'icon' => 'fas fa-building'],
            ['name' => 'Master Penulis', 'slug' => Str::slug('Master Penulis'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/penulis', 'icon' => 'fas fa-pen-nib'],
            ['name' => 'Master Buku', 'slug' => Str::slug('Master Buku'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/buku', 'icon' => 'fas fa-book'],
            ['name' => 'Transaksi', 'slug' => Str::slug('Transaksi'), 'level' => 1, 'parent_id' => null, 'url' => null, 'icon' => 'fas fa-exchange-alt'],
            ['name' => 'Booking', 'slug' => Str::slug('Booking'), 'level' => 2, 'parent_id' => 10, 'url' => '/transaksi/booking', 'icon' => 'fas fa-calendar-check'],
            ['name' => 'Peminjaman', 'slug' => Str::slug('Peminjaman'), 'level' => 2, 'parent_id' => 10, 'url' => '/transaksi/peminjaman', 'icon' => 'fas fa-hand-holding'],
        ]);
    }
}
