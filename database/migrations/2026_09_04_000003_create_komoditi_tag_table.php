<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditi_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komoditi_id')->constrained('komoditi')->cascadeOnDelete();
            $table->string('nama_tag'); // mis. "Ikan Gabui", "Ikan Kuwe" - nama daerah utk Giant Trevally (GT)
            $table->foreignId('ditambahkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // MySQL default collation (utf8mb4_unicode_ci/general_ci) case-insensitive,
            // jadi unique ini otomatis mencegah duplikat "Ikan Kuwe" vs "ikan kuwe".
            $table->unique(['komoditi_id', 'nama_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditi_tag');
    }
};
