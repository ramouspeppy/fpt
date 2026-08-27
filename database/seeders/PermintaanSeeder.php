<?php

namespace Database\Seeders;

use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use App\Models\User;
use Database\Seeders\Concerns\HasDummyData;
use Illuminate\Database\Seeder;

class PermintaanSeeder extends Seeder
{
    use HasDummyData;

    private int $jumlahData = 100;

    public function run(): void
    {
        // Membutuhkan UserSeeder (role Cabang & Pusat) sudah dijalankan lebih dulu.
        $semuaUser = User::role(['Cabang', 'Pusat'])->with('cabang')->get();

        if ($semuaUser->isEmpty()) {
            $this->command->warn('Belum ada user Cabang/Pusat. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= $this->jumlahData; $i++) {
            $user = $semuaUser->random();
            $jenis = $this->jenisIkanAcak();
            $tipe = rand(1, 100) <= 30 ? 'Ekspor' : 'Lokal'; // 30% ekspor
            $volume = rand(50, 1500);
            $dariPusat = $user->hasRole('Pusat');

            $judul = $dariPusat
                ? "Permintaan {$jenis} " . ($tipe === 'Ekspor' ? 'Ekspor' : 'Domestik') . ' - PT ' . $this->namaPTAcak()
                : "Permintaan {$jenis} {$volume}kg - " . ($user->cabang->nama_cabang ?? 'Cabang');

            $permintaan = Permintaan::create([
                'user_id' => $user->id,
                'judul' => $judul,
                'tipe' => $tipe,
                'jenis_ikan' => $jenis,
                'volume' => $volume,
                'harga_maksimal' => rand(20, 130) * 1000,
                'keterangan' => $dariPusat ? 'Kebutuhan buyer, mohon segera dikonfirmasi.' : 'Kebutuhan stok cabang.',
                // indikator prioritas hanya relevan/diisi untuk permintaan dari Pusat
                'prioritas_warna' => $dariPusat ? ['merah', 'kuning', 'hijau'][array_rand(['merah', 'kuning', 'hijau'])] : null,
                'prioritas_tag' => $dariPusat ? $this->tagPrioritasAcak() : null,
                'status' => 'tersedia',
            ]);

            if ($permintaan->isEkspor()) {
                PermintaanDetailEkspor::create([
                    'permintaan_id' => $permintaan->id,
                    'grading' => $this->gradingAcak(),
                    'sertifikasi' => $this->sertifikasiAcak(),
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuanAcak(),
                ]);
            }
        }

        $this->command->info("{$this->jumlahData} permintaan berhasil dibuat.");
    }
}
