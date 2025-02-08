<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->string('nama')->unique(); // Nama kategori harus unik
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Penghapusan sementara
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori');
    }
};
