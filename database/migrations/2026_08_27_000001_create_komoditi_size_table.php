<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditi_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komoditi_id')->constrained('komoditi')->cascadeOnDelete();
            $table->string('nama_size'); // mis. "1000UP", "500-1000", "300-500", "200-300"
            // opsional: urutan tampil. Pakai gap numbering (10, 20, 30, ...) supaya bisa
            // menyisipkan size baru di tengah tanpa geser ulang semua data yang sudah ada.
            // Kalau kosong, fallback urut berdasarkan created_at dan ditaruh di akhir list.
            $table->integer('urutan')->nullable();
            $table->enum('status', ['menunggu_approval', 'disetujui', 'ditolak'])->default('menunggu_approval');
            $table->foreignId('diusulkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['komoditi_id', 'nama_size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditi_size');
    }
};
