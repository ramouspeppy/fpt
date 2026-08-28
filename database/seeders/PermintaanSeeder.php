<?php

namespace Database\Seeders;

use App\Models\Komoditi;
use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use App\Models\User;
use Database\Seeders\Concerns\HasDummyData;
use Illuminate\Database\Seeder;

class PermintaanSeeder extends Seeder
{
    use HasDummyData;

    private int $jumlahData = 100;

    private array $daftarGrade = ['1.000-Up', '500-1.000 A', '300-500 B', '200-300 C'];

    public function run(): void
    {
        $semuaUser = User::role(['Cabang', 'Pusat'])->with('cabang')->get();
        $komoditiList = Komoditi::disetujui()->get();

        if ($semuaUser->isEmpty()) {
            $this->command->warn('Belum ada user Cabang/Pusat. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        if ($komoditiList->isEmpty()) {
            $this->command->warn('Belum ada master data Komoditi. Jalankan KomoditiSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= $this->jumlahData; $i++) {
            $user = $semuaUser->random();
            $komoditi = $komoditiList->random();
            $tipe = rand(1, 100) <= 30 ? 'Ekspor' : 'Lokal';
            $dariPusat = $user->hasRole('Pusat');

            $judul = $dariPusat
                ? "Permintaan {$komoditi->nama} " . ($tipe === 'Ekspor' ? 'Ekspor' : 'Domestik') . ' - PT ' . $this->namaPTAcak()
                : "Permintaan {$komoditi->nama} - " . ($user->cabang->nama_cabang ?? 'Cabang');

            $permintaan = Permintaan::create([
                'user_id' => $user->id,
                'komoditi_id' => $komoditi->id,
                'judul' => $judul,
                'tipe' => $tipe,
                'keterangan' => $dariPusat ? 'Kebutuhan buyer, mohon segera dikonfirmasi.' : 'Kebutuhan stok cabang.',
                'prioritas_warna' => $dariPusat ? ['merah', 'kuning', 'hijau'][array_rand(['merah', 'kuning', 'hijau'])] : null,
                'prioritas_tag' => $dariPusat ? $this->tagPrioritasAcak() : null,
                'status' => 'tersedia',
            ]);

            $jumlahGrade = rand(1, 3);
            $gradeTerpilih = collect($this->daftarGrade)->random($jumlahGrade);
            $hargaDasar = rand(65, 130) * 1000;

            foreach ($gradeTerpilih as $index => $grade) {
                $permintaan->rincianGrade()->create([
                    'ukuran_grade' => $grade,
                    'harga' => max(20000, $hargaDasar - ($index * 20000)),
                    'kuantiti' => rand(50, 1500),
                ]);
            }

            if ($permintaan->isEkspor()) {
                PermintaanDetailEkspor::create([
                    'permintaan_id' => $permintaan->id,
                    'sertifikasi' => $this->sertifikasiAcak(),
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuanAcak(),
                ]);
            }
        }

        $this->command->info("{$this->jumlahData} permintaan (dengan rincian grade) berhasil dibuat.");
    }
}
