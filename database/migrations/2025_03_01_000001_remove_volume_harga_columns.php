<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropColumn(['volume', 'harga']);
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->dropColumn(['volume', 'harga_maksimal']);
        });

        // grading sekarang melekat per baris rincian grade, bukan lagi per posting
        Schema::table('penawaran_detail_ekspor', function (Blueprint $table) {
            $table->dropColumn('grading');
        });

        Schema::table('permintaan_detail_ekspor', function (Blueprint $table) {
            $table->dropColumn('grading');
        });
    }

    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('harga', 15, 2)->nullable();
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('harga_maksimal', 15, 2)->nullable();
        });

        Schema::table('penawaran_detail_ekspor', function (Blueprint $table) {
            $table->string('grading')->nullable();
        });

        Schema::table('permintaan_detail_ekspor', function (Blueprint $table) {
            $table->string('grading')->nullable();
        });
    }
};
