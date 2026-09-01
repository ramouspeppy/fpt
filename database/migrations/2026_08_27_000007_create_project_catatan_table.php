<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_catatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('isi_catatan');
            // Catatan bersifat PERMANEN - tidak ada fitur edit/hapus dari sisi user.
            // Koreksi dilakukan dengan menambah catatan baru, bukan mengubah yang lama.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_catatan');
    }
};
