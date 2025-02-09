<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->decimal('denda', 10, 2)->nullable()->after('tanggal_kembali');

            // Ubah kolom status menjadi enum dengan opsi baru
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi'])
                  ->default('menunggu verifikasi')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Hapus kolom denda
            $table->dropColumn('denda');

            // Kembalikan enum status ke nilai sebelumnya
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam')->change();
        });
    }
};
