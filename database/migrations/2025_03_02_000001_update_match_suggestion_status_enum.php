<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: perluas enum dulu supaya nilai baru bisa dipakai
        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('menunggu_review', 'notifikasi_otomatis', 'disetujui', 'ditolak') NOT NULL DEFAULT 'notifikasi_otomatis'");

        // migrasi data lama: yang sebelumnya 'disetujui' otomatis (tanpa approved_by = tidak ada
        // manusia yang klik setuju) diubah jadi 'notifikasi_otomatis'. Yang memang di-approve
        // manual oleh Pusat (ada approved_by terisi) TETAP 'disetujui'.
        DB::table('match_suggestion')
            ->where('status', 'disetujui')
            ->whereNull('approved_by')
            ->update(['status' => 'notifikasi_otomatis']);
    }

    public function down(): void
    {
        DB::table('match_suggestion')
            ->where('status', 'notifikasi_otomatis')
            ->update(['status' => 'disetujui']);

        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('menunggu_review', 'disetujui', 'ditolak') NOT NULL DEFAULT 'disetujui'");
    }
};
