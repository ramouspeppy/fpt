<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    // Kota-kota pesisir sebagai lokasi cabang, mewakili sebaran nasional
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
        foreach ($this->kotaCabang as $kota) {
            Cabang::firstOrCreate(
                ['nama_cabang' => $kota['nama']],
                ['lokasi' => $kota['lokasi'], 'region' => $kota['region']]
            );
        }

        $this->command->info(count($this->kotaCabang) . ' cabang berhasil dibuat.');
    }
}
