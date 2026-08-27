<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->enum('tipe', ['Ekspor', 'Lokal'])->default('Lokal'); // tidak ada opsi gabungan seperti penawaran
            $table->string('jenis_ikan');
            $table->decimal('volume', 10, 2);
            $table->decimal('harga_maksimal', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            // indikator prioritas: ditandai manual oleh pusat, bukan dihitung otomatis
            $table->string('prioritas_warna')->nullable(); // mis. merah/kuning/hijau
            $table->string('prioritas_tag')->nullable(); // teks bebas, mis. "Urgent - buyer nunggu 3 hari"
            $table->enum('status', ['tersedia', 'matched', 'selesai', 'ditutup'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
