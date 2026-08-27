<?php

namespace Database\Seeders;

use App\Services\MatchingService;
use Illuminate\Database\Seeder;

class MatchingSeeder extends Seeder
{
    public function run(): void
    {
        // Membutuhkan fitur MatchingService sudah terpasang (lihat INTEGRASI_MATCHING.md).
        if (! class_exists(MatchingService::class)) {
            $this->command->warn('MatchingService belum terpasang, lewati pencarian kecocokan otomatis.');
            return;
        }

        $jumlah = app(MatchingService::class)->runAll();

        $this->command->info("{$jumlah} kecocokan ditemukan dari data dummy.");
    }
}
