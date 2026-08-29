<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            // Produksi Sendiri -> section biaya = rincian HPP (proses, packing, listrik, dll)
            // Trading -> section biaya = margin/keuntungan (barang sudah jadi dari mitra)
            // Default 'Produksi Sendiri' untuk data lama yang sudah ada sebelum kolom ini ditambahkan.
            $table->enum('jenis_penawaran', ['Produksi Sendiri', 'Trading'])
                ->default('Produksi Sendiri')
                ->after('tipe');
        });
    }

    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropColumn('jenis_penawaran');
        });
    }
};
