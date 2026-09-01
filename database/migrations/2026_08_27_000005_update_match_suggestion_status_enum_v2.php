<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // status lama: menunggu_review, notifikasi_otomatis, disetujui, ditolak
        // status baru: terbuka, dipilih
        // Semua match sekarang lahir sebagai kandidat "terbuka" - Pusat/Admin yang
        // memilih satu sebagai pemenang (jadi Project), bukan lagi dibedakan ekspor/lokal.

        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('menunggu_review', 'notifikasi_otomatis', 'disetujui', 'ditolak', 'terbuka', 'dipilih') NOT NULL DEFAULT 'terbuka'");

        DB::table('match_suggestion')->whereIn('status', ['menunggu_review', 'notifikasi_otomatis', 'ditolak'])
            ->update(['status' => 'terbuka']);
        DB::table('match_suggestion')->where('status', 'disetujui')
            ->update(['status' => 'dipilih']);

        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('terbuka', 'dipilih') NOT NULL DEFAULT 'terbuka'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('menunggu_review', 'notifikasi_otomatis', 'disetujui', 'ditolak', 'terbuka', 'dipilih') NOT NULL DEFAULT 'terbuka'");

        DB::table('match_suggestion')->where('status', 'terbuka')->update(['status' => 'notifikasi_otomatis']);
        DB::table('match_suggestion')->where('status', 'dipilih')->update(['status' => 'disetujui']);

        DB::statement("ALTER TABLE match_suggestion MODIFY status ENUM('menunggu_review', 'notifikasi_otomatis', 'disetujui', 'ditolak') NOT NULL DEFAULT 'notifikasi_otomatis'");
    }
};
