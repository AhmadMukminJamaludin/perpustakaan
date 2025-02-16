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
        Schema::create('penagihan_denda', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke peminjaman yang terkait dengan denda ini
            $table->unsignedBigInteger('peminjaman_id');
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
            
            // Relasi ke user yang harus membayar denda
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Data transaksi Midtrans
            $table->string('order_id')->unique();
            $table->decimal('gross_amount', 12, 2);
            $table->text('snap_token')->nullable();
            
            // Status pembayaran: misal 'pending', 'settlement', 'deny', dll.
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penagihan_denda');
    }
};
