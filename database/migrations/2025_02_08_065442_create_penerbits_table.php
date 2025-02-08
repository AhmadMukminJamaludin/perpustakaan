<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penerbit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('telepon')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerbit');
    }
};

