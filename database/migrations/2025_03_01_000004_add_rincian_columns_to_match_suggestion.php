<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sekarang 1 match_suggestion mewakili kecocokan 1 PASANGAN BARIS GRADE,
        // bukan lagi 1 pasangan posting. penawaran_id/permintaan_id yang lama tetap
        // dipertahankan sebagai referensi cepat ke posting induknya (denormalisasi).
        Schema::table('match_suggestion', function (Blueprint $table) {
            $table->foreignId('penawaran_rincian_id')->nullable()->after('penawaran_id')
                ->constrained('penawaran_rincian_grade')->cascadeOnDelete();
            $table->foreignId('permintaan_rincian_id')->nullable()->after('permintaan_id')
                ->constrained('permintaan_rincian_grade')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('match_suggestion', function (Blueprint $table) {
            $table->dropConstrainedForeignId('penawaran_rincian_id');
            $table->dropConstrainedForeignId('permintaan_rincian_id');
        });
    }
};
