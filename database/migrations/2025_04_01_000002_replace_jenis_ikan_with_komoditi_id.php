<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropColumn('jenis_ikan');
            $table->foreignId('komoditi_id')->nullable()->after('user_id')->constrained('komoditi')->nullOnDelete();
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->dropColumn('jenis_ikan');
            $table->foreignId('komoditi_id')->nullable()->after('user_id')->constrained('komoditi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropConstrainedForeignId('komoditi_id');
            $table->string('jenis_ikan')->nullable();
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('komoditi_id');
            $table->string('jenis_ikan')->nullable();
        });
    }
};
