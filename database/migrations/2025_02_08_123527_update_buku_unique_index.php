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
        Schema::table('buku', function (Blueprint $table) {
            // Hapus indeks unik yang lama (pastikan nama indeks sesuai dengan yang digunakan)
            $table->dropUnique('buku_isbn_unique');

            // Buat indeks unik komposit pada kolom isbn dan deleted_at
            $table->unique(['isbn', 'deleted_at'], 'buku_isbn_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Hapus indeks unik komposit
            $table->dropUnique('buku_isbn_unique');

            // Buat kembali indeks unik pada kolom isbn saja
            $table->unique('isbn', 'buku_isbn_unique');
        });
    }
};
