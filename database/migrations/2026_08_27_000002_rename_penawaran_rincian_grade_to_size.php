<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('penawaran_rincian_grade', 'penawaran_rincian_size');

        // CATATAN PENTING: ukuran_grade (teks bebas) tidak bisa dipetakan otomatis
        // ke KOMODITI_SIZE karena datanya bisa berupa variasi penulisan ("A" vs
        // "500-1.000 A"). Karena project masih tahap development dengan dummy data,
        // kolom ini langsung dihapus - jalankan `php artisan migrate:fresh --seed`
        // setelah addon ini dipasang, jangan cuma `migrate`.
        Schema::table('penawaran_rincian_size', function (Blueprint $table) {
            $table->dropColumn('ukuran_grade');
            $table->foreignId('komoditi_size_id')->nullable()->after('penawaran_id')
                ->constrained('komoditi_size')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('penawaran_rincian_size', function (Blueprint $table) {
            $table->dropConstrainedForeignId('komoditi_size_id');
            $table->string('ukuran_grade')->nullable();
        });

        Schema::rename('penawaran_rincian_size', 'penawaran_rincian_grade');
    }
};
