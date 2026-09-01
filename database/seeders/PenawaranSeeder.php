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

    public function run(): void
    {
        $userCabang = User::role('Cabang')->with('cabang')->get();
        $komoditiList = Komoditi::disetujui()->with('sizes')->get()->filter(fn ($k) => $k->sizes->where('status', 'disetujui')->isNotEmpty());

        if ($userCabang->isEmpty()) {
            $this->command->warn('Belum ada user dengan role Cabang. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        if ($komoditiList->isEmpty()) {
            $this->command->warn('Belum ada Komoditi dengan Size disetujui. Jalankan KomoditiSeeder & KomoditiSizeSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= $this->jumlahData; $i++) {
            $user = $userCabang->random();
            $komoditi = $komoditiList->random();
            $sizeMilikKomoditi = $komoditi->sizes->where('status', 'disetujui')->values();
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

            // 1-3 baris rincian size per penawaran, harga makin kecil untuk size lebih rendah.
            // CATATAN: Collection::random($n) SELALU balikin Collection walau $n = 1
            // (beda dengan random() tanpa argumen yang balikin single model) - jangan dibungkus collect() lagi.
            $jumlahSize = min(rand(1, 3), $sizeMilikKomoditi->count());
            $sizeTerpilih = $sizeMilikKomoditi->random($jumlahSize)->values();
            $hargaDasar = rand(60, 120) * 1000;

            foreach ($sizeTerpilih as $index => $size) {
                $penawaran->rincianSize()->create([
                    'komoditi_size_id' => $size->id,
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

        $this->command->info("{$this->jumlahData} penawaran (dengan rincian size) berhasil dibuat.");
    }

    private function acakTipePenawaran(): string
    {
        $angka = rand(1, 100);
        if ($angka <= 60) return 'Lokal';
        if ($angka <= 85) return 'Ekspor';
        return 'Ekspor & Lokal';
    }
}
