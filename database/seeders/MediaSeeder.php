<?php

namespace Database\Seeders;

use App\Models\Komoditi;
use App\Models\Penawaran;
use App\Models\Permintaan;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    // Peluang (0-100) sebuah record kebagian foto/video - sengaja TIDAK 100%
    // supaya datanya lebih mirip kondisi asli (tidak semua posting ada fotonya)
    // dan seeding-nya juga lebih cepat.
    private int $peluangFotoKomoditi = 70;
    private int $peluangFotoPenawaran = 60;
    private int $peluangVideoPenawaran = 20;
    private int $peluangFotoPermintaan = 40;
    private int $peluangVideoPermintaan = 10;

    public function run(): void
    {
        $folderFixture = database_path('seeders/fixtures');
        $fotoFixtures = glob($folderFixture . '/images/*.jpg');
        $videoFixtures = glob($folderFixture . '/videos/*.mp4');

        if (empty($fotoFixtures)) {
            $this->command->warn('MediaSeeder: fixture foto tidak ditemukan di database/seeders/fixtures/images - dilewati.');
            return;
        }

        $this->seedFotoKomoditi($fotoFixtures);
        $this->seedGaleri(Penawaran::class, 'Penawaran', $fotoFixtures, $videoFixtures, $this->peluangFotoPenawaran, $this->peluangVideoPenawaran);
        $this->seedGaleri(Permintaan::class, 'Permintaan', $fotoFixtures, $videoFixtures, $this->peluangFotoPermintaan, $this->peluangVideoPermintaan);
    }

    private function seedFotoKomoditi(array $fotoFixtures): void
    {
        $komoditiList = Komoditi::disetujui()->get();
        $jumlah = 0;

        foreach ($komoditiList as $komoditi) {
            if ($komoditi->getMedia('foto')->isNotEmpty()) {
                continue; // sudah punya foto (mis. dari testing manual) - jangan ditimpa
            }

            if (random_int(1, 100) > $this->peluangFotoKomoditi) {
                continue;
            }

            // preservingOriginal() WAJIB - fixture ini dipakai ULANG untuk banyak record,
            // tanpa ini Spatie akan MENGHAPUS file sumbernya setelah pemakaian pertama.
            $komoditi->addMedia($fotoFixtures[array_rand($fotoFixtures)])
                ->preservingOriginal()
                ->toMediaCollection('foto');

            $jumlah++;
        }

        $this->command->info("MediaSeeder: {$jumlah} Komoditi dapat foto.");
    }

    private function seedGaleri(string $modelClass, string $label, array $fotoFixtures, array $videoFixtures, int $peluangFoto, int $peluangVideo): void
    {
        $records = $modelClass::all();
        $jumlahFoto = 0;
        $jumlahVideo = 0;

        foreach ($records as $record) {
            if ($record->getMedia('foto')->isEmpty() && random_int(1, 100) <= $peluangFoto) {
                $banyakFoto = random_int(1, 4); // galeri bebas jumlah - variasikan 1-4 biar realistis

                for ($i = 0; $i < $banyakFoto; $i++) {
                    $record->addMedia($fotoFixtures[array_rand($fotoFixtures)])
                        ->preservingOriginal()
                        ->toMediaCollection('foto');
                }

                $jumlahFoto++;
            }

            if (! empty($videoFixtures) && $record->getMedia('video')->isEmpty() && random_int(1, 100) <= $peluangVideo) {
                $banyakVideo = random_int(1, min(2, count($videoFixtures))); // maks 2 sesuai aturan aplikasi

                foreach (collect($videoFixtures)->shuffle()->take($banyakVideo) as $videoPath) {
                    $record->addMedia($videoPath)
                        ->preservingOriginal()
                        ->toMediaCollection('video');
                }

                $jumlahVideo++;
            }
        }

        $this->command->info("MediaSeeder: {$label} - {$jumlahFoto} dapat foto, {$jumlahVideo} dapat video.");
    }
}
