<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Catatan: migration ini menambah kolom ke tabel `users` bawaan Laravel Breeze.
// Tabel `users` inilah yang berfungsi sebagai USER_AKUN pada skema yang sudah didiskusikan.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('cabang_id')->nullable()->after('id')->constrained('cabang')->nullOnDelete();
            $table->string('no_whatsapp')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cabang_id');
            $table->dropColumn('no_whatsapp');
        });
    }
};
