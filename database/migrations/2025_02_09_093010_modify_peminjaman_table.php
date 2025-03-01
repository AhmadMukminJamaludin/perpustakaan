<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

            // Ubah status menjadi VARCHAR lalu tambahkan CHECK constraint
            $table->string('status', 255)->default('menunggu verifikasi')->change();
        });

        // Tambahkan constraint manual setelah perubahan tipe data
        DB::statement("ALTER TABLE peminjaman ADD CONSTRAINT peminjaman_status_check CHECK (status IN ('dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi'));");
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Hapus constraint sebelum mengubah kembali
            DB::statement("ALTER TABLE peminjaman DROP CONSTRAINT peminjaman_status_check");

            // Kembalikan ke enum lama dengan tiga nilai
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam')->change();

            // Hapus kolom denda
            $table->dropColumn('denda');
        });
    }
};
