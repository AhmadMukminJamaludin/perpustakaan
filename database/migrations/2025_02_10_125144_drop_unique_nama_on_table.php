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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
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
};
