<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran_detail_ekspor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->cascadeOnDelete();
            $table->string('grading')->nullable(); // size, kesegaran, dll
            $table->string('sertifikasi')->nullable(); // mis. HACCP
            $table->string('kontinuitas_suplai')->nullable(); // self-declare oleh cabang
            $table->string('negara_tujuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_detail_ekspor');
    }
};
