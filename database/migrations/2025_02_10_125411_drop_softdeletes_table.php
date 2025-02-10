<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('penerbit', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('penulis', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('penerbit', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('penulis', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
