<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul'); // judul bebas, mis. "Surplus Kembung Kuring 500kg - Cabang Medan"
            $table->enum('tipe', ['Ekspor', 'Lokal', 'Ekspor & Lokal'])->default('Lokal');
            $table->string('jenis_ikan');
            $table->decimal('volume', 10, 2); // dalam kg, 1 kolom saja (tidak dipecah ekspor/lokal)
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('kondisi_ikan')->nullable(); // segar / beku / dll
            $table->text('keterangan')->nullable();
            // status diubah manual oleh user pemilik atau admin, tidak ada auto-expired
            $table->enum('status', ['tersedia', 'matched', 'selesai', 'ditutup'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};
