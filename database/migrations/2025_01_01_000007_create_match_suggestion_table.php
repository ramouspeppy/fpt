<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_suggestion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->cascadeOnDelete();
            $table->foreignId('permintaan_id')->constrained('permintaan')->cascadeOnDelete();
            $table->decimal('skor_matching', 5, 2)->nullable(); // opsional, tampilan urutan relevansi
            // match biasa/lokal -> auto notifikasi (status langsung 'disetujui')
            // match ekspor -> wajib direview pusat (status 'menunggu_review' dulu)
            $table->enum('status', ['menunggu_review', 'disetujui', 'ditolak'])->default('disetujui');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_suggestion');
    }
};
