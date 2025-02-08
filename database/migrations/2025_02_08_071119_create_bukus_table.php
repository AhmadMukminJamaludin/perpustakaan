<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('isbn')->unique(); // ISBN harus unik
            $table->string('judul');
            $table->uuid('kategori_id');
            $table->uuid('penulis_id');
            $table->uuid('penerbit_id');
            $table->integer('tahun_terbit');
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            // Relasi ke tabel lain
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('penulis_id')->references('id')->on('penulis')->onDelete('cascade');
            $table->foreign('penerbit_id')->references('id')->on('penerbit')->onDelete('cascade');

            // Index untuk pencarian cepat
            $table->index(['judul', 'isbn']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
