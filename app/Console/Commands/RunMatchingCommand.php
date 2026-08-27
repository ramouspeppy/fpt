<?php

namespace App\Console\Commands;

use App\Services\MatchingService;
use Illuminate\Console\Command;

class RunMatchingCommand extends Command
{
    protected $signature = 'matching:run';

    protected $description = 'Scan semua penawaran & permintaan yang masih tersedia, cari kecocokan baru';

    public function handle(MatchingService $service): int
    {
        $this->info('Menjalankan pencarian kecocokan...');

        $jumlah = $service->runAll();

        $this->info("Selesai. {$jumlah} kecocokan baru ditemukan.");

        return self::SUCCESS;
    }
}
