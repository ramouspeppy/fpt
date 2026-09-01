<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // status lama: tersedia, matched, selesai, ditutup
        // status baru: tersedia, sedang_diproses, selesai, tutup

        DB::statement("ALTER TABLE penawaran MODIFY status ENUM('tersedia', 'matched', 'sedang_diproses', 'selesai', 'ditutup', 'tutup') NOT NULL DEFAULT 'tersedia'");
        DB::table('penawaran')->where('status', 'matched')->update(['status' => 'sedang_diproses']);
        DB::table('penawaran')->where('status', 'ditutup')->update(['status' => 'tutup']);
        DB::statement("ALTER TABLE penawaran MODIFY status ENUM('tersedia', 'sedang_diproses', 'selesai', 'tutup') NOT NULL DEFAULT 'tersedia'");

        DB::statement("ALTER TABLE permintaan MODIFY status ENUM('tersedia', 'matched', 'sedang_diproses', 'selesai', 'ditutup', 'tutup') NOT NULL DEFAULT 'tersedia'");
        DB::table('permintaan')->where('status', 'matched')->update(['status' => 'sedang_diproses']);
        DB::table('permintaan')->where('status', 'ditutup')->update(['status' => 'tutup']);
        DB::statement("ALTER TABLE permintaan MODIFY status ENUM('tersedia', 'sedang_diproses', 'selesai', 'tutup') NOT NULL DEFAULT 'tersedia'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE penawaran MODIFY status ENUM('tersedia', 'matched', 'sedang_diproses', 'selesai', 'ditutup', 'tutup') NOT NULL DEFAULT 'tersedia'");
        DB::table('penawaran')->where('status', 'sedang_diproses')->update(['status' => 'matched']);
        DB::table('penawaran')->where('status', 'tutup')->update(['status' => 'ditutup']);
        DB::statement("ALTER TABLE penawaran MODIFY status ENUM('tersedia', 'matched', 'selesai', 'ditutup') NOT NULL DEFAULT 'tersedia'");

        DB::statement("ALTER TABLE permintaan MODIFY status ENUM('tersedia', 'matched', 'sedang_diproses', 'selesai', 'ditutup', 'tutup') NOT NULL DEFAULT 'tersedia'");
        DB::table('permintaan')->where('status', 'sedang_diproses')->update(['status' => 'matched']);
        DB::table('permintaan')->where('status', 'tutup')->update(['status' => 'ditutup']);
        DB::statement("ALTER TABLE permintaan MODIFY status ENUM('tersedia', 'matched', 'selesai', 'ditutup') NOT NULL DEFAULT 'tersedia'");
    }
};
