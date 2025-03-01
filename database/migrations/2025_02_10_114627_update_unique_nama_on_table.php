<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus constraint unik lama jika ada
        DB::statement('ALTER TABLE kategori DROP CONSTRAINT IF EXISTS kategori_nama_unique');
        DB::statement('ALTER TABLE penerbit DROP CONSTRAINT IF EXISTS penerbit_nama_unique');
        DB::statement('ALTER TABLE penerbit DROP CONSTRAINT IF EXISTS penerbit_email_unique');
        DB::statement('ALTER TABLE penulis DROP CONSTRAINT IF EXISTS penulis_email_unique');

        // Update tabel kategori
        Schema::table('kategori', function (Blueprint $table) {
            $table->unique(['nama', 'deleted_at']);
        });

        // Update tabel penerbit
        Schema::table('penerbit', function (Blueprint $table) {
            $table->unique(['nama', 'deleted_at']);
            $table->unique(['email', 'deleted_at']);
        });

        // Update tabel penulis
        Schema::table('penulis', function (Blueprint $table) {
            $table->unique(['email', 'deleted_at']);
        });
    }

    public function down()
    {
        // Hapus unique constraint jika rollback
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropUnique(['nama', 'deleted_at']);
        });

        Schema::table('penerbit', function (Blueprint $table) {
            $table->dropUnique(['nama', 'deleted_at']);
            $table->dropUnique(['email', 'deleted_at']);
        });

        Schema::table('penulis', function (Blueprint $table) {
            $table->dropUnique(['email', 'deleted_at']);
        });
    }
};
