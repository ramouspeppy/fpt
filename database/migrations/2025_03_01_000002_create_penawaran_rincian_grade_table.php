<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran_rincian_grade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->cascadeOnDelete();
            $table->string('ukuran_grade'); // mis. "1.000-Up", "500-1.000 A", "300-500 B"
            $table->decimal('harga', 15, 2);
            $table->decimal('kuantiti', 10, 2); // dalam kg
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_rincian_grade');
    }
};
