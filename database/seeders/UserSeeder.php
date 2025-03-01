<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role sudah ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $pengunjungRole = Role::firstOrCreate(['name' => 'pengunjung']);

        // Buat user admin jika belum ada
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat
        ]);
        $admin->assignRole($adminRole);

        // Buat user pengunjung jika belum ada
        $pengunjung = User::firstOrCreate([
            'email' => 'pengunjung@example.com',
        ], [
            'name' => 'Pengunjung User',
            'password' => Hash::make('password'),
        ]);
        $pengunjung->assignRole($pengunjungRole);
    }
}
