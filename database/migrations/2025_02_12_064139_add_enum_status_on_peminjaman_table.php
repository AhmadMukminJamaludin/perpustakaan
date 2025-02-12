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
            $table->decimal('denda_kehilangan', 10, 2)->nullable()->after('denda');
            $table->string('keterangan_kehilangan')->nullable()->after('status');
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi', 'hilang'])
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
            $table->dropColumn(['keterangan_kehilangan', 'denda_kehilangan']);
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi'])
                  ->default('menunggu verifikasi')
                  ->change();
        });
    }
};
