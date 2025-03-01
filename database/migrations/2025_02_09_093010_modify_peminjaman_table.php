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
        // 1. Buat ENUM baru
        DB::statement("CREATE TYPE status_enum AS ENUM ('dipinjam', 'dikembalikan', 'terlambat', 'menunggu verifikasi');");

        // 2. Hapus default value sebelum mengubah tipe
        DB::statement("ALTER TABLE peminjaman ALTER COLUMN status DROP DEFAULT;");

        // 3. Ubah tipe data status ke ENUM
        DB::statement("ALTER TABLE peminjaman ALTER COLUMN status TYPE status_enum USING status::text::status_enum;");

        // 4. Set default value kembali
        DB::statement("ALTER TABLE peminjaman ALTER COLUMN status SET DEFAULT 'menunggu verifikasi';");
    }

    public function down(): void
    {
        // 1. Hapus default value sebelum rollback
        DB::statement("ALTER TABLE peminjaman ALTER COLUMN status DROP DEFAULT;");

        // 2. Ubah kembali ke VARCHAR
        DB::statement("ALTER TABLE peminjaman ALTER COLUMN status TYPE VARCHAR(255) USING status::text;");

        // 3. Hapus tipe ENUM
        DB::statement("DROP TYPE status_enum;");
    }

};
