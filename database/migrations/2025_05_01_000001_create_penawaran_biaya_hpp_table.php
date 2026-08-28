<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran_biaya_hpp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->cascadeOnDelete();
            $table->string('label'); // mis. "Biaya Proses", "Biaya Packing", "Biaya Listrik", dst - bebas
            $table->decimal('jumlah', 15, 2); // dalam Rp/kg, berlaku sama untuk semua grade di penawaran ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_biaya_hpp');
    }
};
