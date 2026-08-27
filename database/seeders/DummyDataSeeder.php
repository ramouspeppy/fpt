<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Penawaran;
use App\Models\PenawaranDetailEkspor;
use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use App\Models\User;
use App\Services\MatchingService;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    private array $jenisIkan = [
        'Kembung Kuring', 'Tongkol', 'Tenggiri', 'Kakap Merah', 'Kerapu',
        'Gurita', 'Cumi-cumi', 'Udang Vaname', 'Kakaktua', 'Bawal',
        'Tuna Sirip Kuning', 'Layang', 'Selar', 'Bandeng', 'Rajungan',
        'Cakalang', 'Baronang', 'Ekor Kuning', 'Kepiting Bakau', 'Lobster',
    ];

    private array $kondisiIkan = ['Segar', 'Beku', 'Segar - Baru Ditangkap', 'Beku - Cold Storage'];

    private array $negaraTujuan = ['Jepang', 'China', 'Amerika Serikat', 'Korea Selatan', 'Uni Eropa', 'Malaysia', 'Singapura'];

    private array $grading = ['A', 'B', 'Super', 'Premium', 'Grade Ekspor 1', 'Grade Ekspor 2'];

    private array $sertifikasi = ['HACCP', 'MSC', 'BRC', 'HACCP + MSC', null];

    // kota-kota pesisir sebagai lokasi cabang, mewakili sebaran nasional
    private array $kotaCabang = [
        ['nama' => 'Cabang Medan', 'lokasi' => 'Medan, Sumatera Utara', 'region' => 'Sumatera'],
        ['nama' => 'Cabang Padang', 'lokasi' => 'Padang, Sumatera Barat', 'region' => 'Sumatera'],
        ['nama' => 'Cabang Palembang', 'lokasi' => 'Palembang, Sumatera Selatan', 'region' => 'Sumatera'],
        ['nama' => 'Cabang Lampung', 'lokasi' => 'Bandar Lampung, Lampung', 'region' => 'Sumatera'],
        ['nama' => 'Cabang Jakarta', 'lokasi' => 'Jakarta Utara, DKI Jakarta', 'region' => 'Jawa'],
        ['nama' => 'Cabang Cirebon', 'lokasi' => 'Cirebon, Jawa Barat', 'region' => 'Jawa'],
        ['nama' => 'Cabang Pekalongan', 'lokasi' => 'Pekalongan, Jawa Tengah', 'region' => 'Jawa'],
        ['nama' => 'Cabang Semarang', 'lokasi' => 'Semarang, Jawa Tengah', 'region' => 'Jawa'],
        ['nama' => 'Cabang Surabaya', 'lokasi' => 'Surabaya, Jawa Timur', 'region' => 'Jawa'],
        ['nama' => 'Cabang Denpasar', 'lokasi' => 'Denpasar, Bali', 'region' => 'Bali & Nusa Tenggara'],
        ['nama' => 'Cabang Kupang', 'lokasi' => 'Kupang, Nusa Tenggara Timur', 'region' => 'Bali & Nusa Tenggara'],
        ['nama' => 'Cabang Pontianak', 'lokasi' => 'Pontianak, Kalimantan Barat', 'region' => 'Kalimantan'],
        ['nama' => 'Cabang Banjarmasin', 'lokasi' => 'Banjarmasin, Kalimantan Selatan', 'region' => 'Kalimantan'],
        ['nama' => 'Cabang Balikpapan', 'lokasi' => 'Balikpapan, Kalimantan Timur', 'region' => 'Kalimantan'],
        ['nama' => 'Cabang Makassar', 'lokasi' => 'Makassar, Sulawesi Selatan', 'region' => 'Sulawesi'],
        ['nama' => 'Cabang Manado', 'lokasi' => 'Manado, Sulawesi Utara', 'region' => 'Sulawesi'],
        ['nama' => 'Cabang Bitung', 'lokasi' => 'Bitung, Sulawesi Utara', 'region' => 'Sulawesi'],
        ['nama' => 'Cabang Ambon', 'lokasi' => 'Ambon, Maluku', 'region' => 'Maluku & Papua'],
        ['nama' => 'Cabang Ternate', 'lokasi' => 'Ternate, Maluku Utara', 'region' => 'Maluku & Papua'],
        ['nama' => 'Cabang Sorong', 'lokasi' => 'Sorong, Papua Barat', 'region' => 'Maluku & Papua'],
    ];

    public function run(): void
    {
        $this->command->info('Membuat data cabang...');
        $cabangList = $this->buatCabang();

        $this->command->info('Membuat data user...');
        $userList = $this->buatUser($cabangList);

        $this->command->info('Membuat data penawaran...');
        $this->buatPenawaran($userList['cabang']);

        $this->command->info('Membuat data permintaan...');
        $this->buatPermintaan($userList['semua']);

        $this->command->info('Menjalankan pencarian kecocokan otomatis...');
        $jumlahMatch = app(MatchingService::class)->runAll();
        $this->command->info("Selesai. {$jumlahMatch} kecocokan ditemukan dari data dummy.");
    }

    private function buatCabang(): array
    {
        $hasil = [];

        foreach ($this->kotaCabang as $kota) {
            $hasil[] = Cabang::create([
                'nama_cabang' => $kota['nama'],
                'lokasi' => $kota['lokasi'],
                'region' => $kota['region'],
            ]);
        }

        return $hasil;
    }

    private function buatUser(array $cabangList): array
    {
        $userCabang = [];

        // 1 Admin (tidak terikat cabang)
        $admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'cabang_id' => null,
            'no_whatsapp' => $this->nomorWhatsapp(),
        ]);
        $admin->assignRole('Admin');

        // 3 user Pusat/Pemasaran (tidak terikat cabang, bisa upload permintaan buyer eksternal)
        $namaPusat = ['Rudi Hartono', 'Siti Aminah', 'Bambang Setiawan'];
        $userPusat = [];
        foreach ($namaPusat as $i => $nama) {
            $user = User::create([
                'name' => $nama,
                'email' => 'pusat' . ($i + 1) . '@example.com',
                'password' => bcrypt('password'),
                'cabang_id' => null,
                'no_whatsapp' => $this->nomorWhatsapp(),
            ]);
            $user->assignRole('Pusat');
            $userPusat[] = $user;
        }

        // 1-2 user per cabang dengan role Cabang
        $namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lestari', 'Made', 'Nur', 'Oki', 'Putri', 'Rahmat', 'Sari', 'Taufik', 'Umar', 'Vina', 'Wawan', 'Yanto', 'Zainal'];
        $namaBelakang = ['Saputra', 'Wijaya', 'Kusuma', 'Pratama', 'Santoso', 'Nugroho', 'Handoko', 'Permana', 'Utami', 'Siregar'];

        foreach ($cabangList as $cabang) {
            $jumlahUser = rand(1, 2);
            for ($i = 0; $i < $jumlahUser; $i++) {
                $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
                $email = 'cabang' . $cabang->id . '_' . ($i + 1) . '@example.com';

                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'cabang_id' => $cabang->id,
                    'no_whatsapp' => $this->nomorWhatsapp(),
                ]);
                $user->assignRole('Cabang');
                $userCabang[] = $user;
            }
        }

        return [
            'cabang' => $userCabang,
            'pusat' => $userPusat,
            'admin' => $admin,
            'semua' => array_merge($userCabang, $userPusat),
        ];
    }

    private function buatPenawaran(array $userCabang): void
    {
        // 100 penawaran, dibuat oleh user cabang secara acak
        // distribusi tipe: 60% Lokal, 25% Ekspor, 15% Ekspor & Lokal
        for ($i = 1; $i <= 100; $i++) {
            $user = $userCabang[array_rand($userCabang)];
            $jenis = $this->jenisIkan[array_rand($this->jenisIkan)];
            $tipe = $this->acakTipePenawaran();
            $volume = rand(50, 2000);

            $penawaran = Penawaran::create([
                'user_id' => $user->id,
                'judul' => "Surplus {$jenis} {$volume}kg - {$user->cabang->nama_cabang}",
                'tipe' => $tipe,
                'jenis_ikan' => $jenis,
                'volume' => $volume,
                'harga' => rand(15, 120) * 1000,
                'kondisi_ikan' => $this->kondisiIkan[array_rand($this->kondisiIkan)],
                'keterangan' => 'Stok surplus musim panen, kualitas baik.',
                'status' => 'tersedia',
            ]);

            if ($penawaran->mengandungEkspor()) {
                PenawaranDetailEkspor::create([
                    'penawaran_id' => $penawaran->id,
                    'grading' => $this->grading[array_rand($this->grading)],
                    'sertifikasi' => $this->sertifikasi[array_rand($this->sertifikasi)],
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuan[array_rand($this->negaraTujuan)],
                ]);
            }
        }
    }

    private function buatPermintaan(array $semuaUser): void
    {
        // 100 permintaan, campuran dari user cabang & user pusat (buyer eksternal)
        for ($i = 1; $i <= 100; $i++) {
            $user = $semuaUser[array_rand($semuaUser)];
            $jenis = $this->jenisIkan[array_rand($this->jenisIkan)];
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
                    'grading' => $this->grading[array_rand($this->grading)],
                    'sertifikasi' => $this->sertifikasi[array_rand($this->sertifikasi)],
                    'kontinuitas_suplai' => $this->kontinuitasAcak(),
                    'negara_tujuan' => $this->negaraTujuan[array_rand($this->negaraTujuan)],
                ]);
            }
        }
    }

    private function acakTipePenawaran(): string
    {
        $angka = rand(1, 100);
        if ($angka <= 60) return 'Lokal';
        if ($angka <= 85) return 'Ekspor';
        return 'Ekspor & Lokal';
    }

    private function nomorWhatsapp(): string
    {
        return '08' . rand(11, 99) . rand(1000000, 9999999);
    }

    private function kontinuitasAcak(): string
    {
        $opsi = [
            'Rutin tiap minggu, kapasitas stabil',
            'Musiman, tergantung hasil tangkapan',
            'Bisa kontinu jika ada kepastian pembeli',
            'Rutin 2 minggu sekali',
        ];

        return $opsi[array_rand($opsi)];
    }

    private function namaPTAcak(): string
    {
        $opsi = ['Sumber Laut Jaya', 'Nusantara Bahari', 'Cipta Samudra', 'Mitra Perikanan Indonesia', 'Bahari Sejahtera'];

        return $opsi[array_rand($opsi)];
    }

    private function tagPrioritasAcak(): string
    {
        $opsi = [
            'Urgent - buyer menunggu konfirmasi 3 hari',
            'Kontrak rutin bulanan',
            'Peluang baru, belum ada komitmen pasti',
            'Buyer lama, prioritas jaga hubungan',
        ];

        return $opsi[array_rand($opsi)];
    }
}
