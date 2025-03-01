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
        // Buat tipe ENUM baru
        DB::statement("CREATE TYPE status_enum AS ENUM ('dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi');");

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->decimal('denda', 10, 2)->nullable()->after('tanggal_kembali');

            // Ubah kolom status menjadi tipe ENUM baru
            DB::statement("ALTER TABLE peminjaman ALTER COLUMN status TYPE status_enum USING status::text::status_enum;");
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah kembali ke ENUM lama dengan tiga nilai
            DB::statement("ALTER TABLE peminjaman ALTER COLUMN status TYPE VARCHAR(255);");

            // Hapus tipe ENUM
            DB::statement("DROP TYPE status_enum;");

            // Hapus kolom denda
            $table->dropColumn('denda');
        });
    }
};
