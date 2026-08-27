<?php

namespace Database\Seeders;

use App\Models\Penawaran;
use App\Models\PenawaranDetailEkspor;
use App\Models\User;
use Database\Seeders\Concerns\HasDummyData;
use Illuminate\Database\Seeder;

class PenawaranSeeder extends Seeder
{
    use HasDummyData;

    private int $jumlahData = 100;

    public function run(): void
    {
        // Membutuhkan UserSeeder (role Cabang) sudah dijalankan lebih dulu.
        $userCabang = User::role('Cabang')->with('cabang')->get();

        if ($userCabang->isEmpty()) {
            $this->command->warn('Belum ada user dengan role Cabang. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= $this->jumlahData; $i++) {
            $user = $userCabang->random();
            $jenis = $this->jenisIkanAcak();
            $tipe = $this->acakTipePenawaran();
            $volume = rand(50, 2000);

            $penawaran = Penawaran::create([
                'user_id' => $user->id,
                'judul' => "Surplus {$jenis} {$volume}kg - {$user->cabang->nama_cabang}",
                'tipe' => $tipe,
                'jenis_ikan' => $jenis,
                'volume' => $volume,
                'harga' => rand(15, 120) * 1000,
                'kondisi_ikan' => $this->kondisiIkanAcak(),
                'keterangan' => 'Stok surplus musim panen, kualitas baik.',
                'status' => 'tersedia',
            ]);

            if ($penawaran->mengandungEkspor()) {
                PenawaranDetailEkspor::create([
                    'penawaran_id' => $penawaran->id,
                    'grading' => $this->gradingAcak(),
                    'sertifikasi' => $this->sertifikasiAcak(),
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuanAcak(),
                ]);
            }
        }

        $this->command->info("{$this->jumlahData} penawaran berhasil dibuat.");
    }

    // distribusi tipe: 60% Lokal, 25% Ekspor, 15% Ekspor & Lokal
    private function acakTipePenawaran(): string
    {
        $angka = rand(1, 100);
        if ($angka <= 60) return 'Lokal';
        if ($angka <= 85) return 'Ekspor';
        return 'Ekspor & Lokal';
    }
}
