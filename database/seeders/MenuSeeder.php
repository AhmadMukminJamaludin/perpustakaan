<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Jika tabel menu belum kosong, hapus data lama
        DB::table('menu')->truncate();

        // Insert top-level menus dengan ID spesifik
        DB::table('menu')->insert([
            ['id' => 1, 'no_urut' => 1, 'name' => 'Dashboard',   'slug' => Str::slug('Dashboard'),   'level' => 1, 'parent_id' => null, 'url' => '/dashboard',            'icon' => 'fas fa-tachometer-alt'],
            ['id' => 2, 'no_urut' => 2, 'name' => 'Profil',      'slug' => Str::slug('Profil'),      'level' => 1, 'parent_id' => null, 'url' => '/profile',              'icon' => 'fas fa-user'],
            ['id' => 3, 'no_urut' => 3, 'name' => 'Koleksi Buku','slug' => Str::slug('Koleksi Buku'),'level' => 1, 'parent_id' => null, 'url' => '/',                      'icon' => 'fas fa-cart-shopping'],
            ['id' => 4, 'no_urut' => 4, 'name' => 'Master Data', 'slug' => Str::slug('Master Data'),'level' => 1, 'parent_id' => null, 'url' => null,                     'icon' => 'fas fa-database'],
            ['id' => 5, 'no_urut' => 5, 'name' => 'Transaksi',   'slug' => Str::slug('Transaksi'),   'level' => 1, 'parent_id' => null, 'url' => null,                     'icon' => 'fas fa-exchange-alt'],
            ['id' => 6, 'no_urut' => 6, 'name' => 'Laporan',     'slug' => Str::slug('Laporan'),     'level' => 1, 'parent_id' => null, 'url' => null,                     'icon' => 'fas fa-chart-bar'],
        ]);

        // Insert sub-menu
        DB::table('menu')->insert([
            // Master Data children
            ['no_urut' => 1, 'name' => 'Pengguna',        'slug' => Str::slug('Pengguna'),        'level' => 2, 'parent_id' => 4, 'url' => '/master/users',      'icon' => 'fas fa-users'],
            ['no_urut' => 2, 'name' => 'Master Kategori', 'slug' => Str::slug('Master Kategori'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/kategori',   'icon' => 'fas fa-tags'],
            ['no_urut' => 3, 'name' => 'Master Penerbit', 'slug' => Str::slug('Master Penerbit'), 'level' => 2, 'parent_id' => 4, 'url' => '/master/penerbit',   'icon' => 'fas fa-building'],
            ['no_urut' => 4, 'name' => 'Master Penulis',  'slug' => Str::slug('Master Penulis'),  'level' => 2, 'parent_id' => 4, 'url' => '/master/penulis',    'icon' => 'fas fa-pen-nib'],
            ['no_urut' => 5, 'name' => 'Master Buku',     'slug' => Str::slug('Master Buku'),     'level' => 2, 'parent_id' => 4, 'url' => '/master/buku',       'icon' => 'fas fa-book'],

            // Transaksi children
            ['no_urut' => 1, 'name' => 'Booking',         'slug' => Str::slug('Booking'),         'level' => 2, 'parent_id' => 5, 'url' => '/transaksi/booking', 'icon' => 'fas fa-calendar-check'],
            ['no_urut' => 2, 'name' => 'Peminjaman',      'slug' => Str::slug('Peminjaman'),      'level' => 2, 'parent_id' => 5, 'url' => '/transaksi/peminjaman','icon' => 'fas fa-hand-holding'],

            // Laporan children
            ['no_urut' => 1, 'name' => 'Peminjaman',      'slug' => Str::slug('Laporan Peminjaman'),'level' => 2, 'parent_id' => 6, 'url' => '/laporan/peminjaman','icon' => 'fas fa-file-alt'],
        ]);
    }
}
