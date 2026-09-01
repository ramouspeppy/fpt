<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('permintaan_rincian_grade', 'permintaan_rincian_size');

        Schema::table('permintaan_rincian_size', function (Blueprint $table) {
            $table->dropColumn('ukuran_grade');
            $table->foreignId('komoditi_size_id')->nullable()->after('permintaan_id')
                ->constrained('komoditi_size')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_rincian_size', function (Blueprint $table) {
            $table->dropConstrainedForeignId('komoditi_size_id');
            $table->string('ukuran_grade')->nullable();
        });

        Schema::rename('permintaan_rincian_size', 'permintaan_rincian_grade');
    }
};
