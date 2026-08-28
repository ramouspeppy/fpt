<?php

namespace Database\Seeders;

use App\Models\Komoditi;
use App\Models\Penawaran;
use App\Models\PenawaranDetailEkspor;
use App\Models\User;
use Database\Seeders\Concerns\HasDummyData;
use Illuminate\Database\Seeder;

class PenawaranSeeder extends Seeder
{
    use HasDummyData;

    private int $jumlahData = 100;

    private array $daftarGrade = ['1.000-Up', '500-1.000 A', '300-500 B', '200-300 C'];

    public function run(): void
    {
        $userCabang = User::role('Cabang')->with('cabang')->get();
        $komoditiList = Komoditi::disetujui()->get();

        if ($userCabang->isEmpty()) {
            $this->command->warn('Belum ada user dengan role Cabang. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        if ($komoditiList->isEmpty()) {
            $this->command->warn('Belum ada master data Komoditi. Jalankan KomoditiSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= $this->jumlahData; $i++) {
            $user = $userCabang->random();
            $komoditi = $komoditiList->random();
            $tipe = $this->acakTipePenawaran();

            $penawaran = Penawaran::create([
                'user_id' => $user->id,
                'komoditi_id' => $komoditi->id,
                'judul' => "Surplus {$komoditi->nama} - {$user->cabang->nama_cabang}",
                'tipe' => $tipe,
                'kondisi_ikan' => $this->kondisiIkanAcak(),
                'keterangan' => 'Stok surplus musim panen, kualitas baik.',
                'status' => 'tersedia',
            ]);

            // 1-3 baris rincian grade per penawaran, harga makin kecil untuk grade lebih rendah
            $jumlahGrade = rand(1, 3);
            $gradeTerpilih = collect($this->daftarGrade)->random($jumlahGrade);
            $hargaDasar = rand(60, 120) * 1000;

            foreach ($gradeTerpilih as $index => $grade) {
                $penawaran->rincianGrade()->create([
                    'ukuran_grade' => $grade,
                    'harga' => max(20000, $hargaDasar - ($index * 20000)),
                    'kuantiti' => rand(50, 2000),
                ]);
            }

            if ($penawaran->mengandungEkspor()) {
                PenawaranDetailEkspor::create([
                    'penawaran_id' => $penawaran->id,
                    'sertifikasi' => $this->sertifikasiAcak(),
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuanAcak(),
                ]);
            }
        }

        $this->command->info("{$this->jumlahData} penawaran (dengan rincian grade) berhasil dibuat.");
    }

    private function acakTipePenawaran(): string
    {
        $angka = rand(1, 100);
        if ($angka <= 60) return 'Lokal';
        if ($angka <= 85) return 'Ekspor';
        return 'Ekspor & Lokal';
    }
}
