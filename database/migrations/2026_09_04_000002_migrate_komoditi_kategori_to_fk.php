<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // CATATAN: kolom 'kategori' (teks bebas) tidak bisa dipetakan otomatis ke
        // kategori_komoditi karena datanya bisa berupa variasi penulisan. Karena project
        // masih tahap development dengan dummy data, kolom ini langsung dihapus - jalankan
        // `php artisan migrate:fresh --seed` setelah addon ini dipasang, jangan cuma `migrate`.
        Schema::table('komoditi', function (Blueprint $table) {
            $table->dropColumn('kategori');
            $table->foreignId('kategori_id')->nullable()->after('nama')
                ->constrained('kategori_komoditi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('komoditi', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_id');
            $table->string('kategori')->nullable();
        });
    }
};
