<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditi', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('kategori')->nullable(); // mis. Ikan, Udang, Kepiting, Cumi & Gurita
            // usulan dari Cabang -> menunggu_approval; input langsung oleh Admin/Pusat -> disetujui otomatis
            $table->enum('status', ['menunggu_approval', 'disetujui', 'ditolak'])->default('menunggu_approval');
            $table->foreignId('diusulkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditi');
    }
};
