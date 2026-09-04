<?php

namespace Database\Seeders;

use App\Models\KategoriKomoditi;
use App\Models\Komoditi;
use App\Models\User;
use Illuminate\Database\Seeder;

class KomoditiSeeder extends Seeder
{
    private array $daftarKomoditi = [
        // Ikan
        ['nama' => 'Kembung Kuring', 'kategori' => 'Ikan'],
        ['nama' => 'Tongkol', 'kategori' => 'Ikan'],
        ['nama' => 'Tenggiri', 'kategori' => 'Ikan'],
        ['nama' => 'Kakap Merah', 'kategori' => 'Ikan'],
        ['nama' => 'Kerapu', 'kategori' => 'Ikan'],
        ['nama' => 'Kakaktua', 'kategori' => 'Ikan'],
        ['nama' => 'Bawal', 'kategori' => 'Ikan'],
        ['nama' => 'Tuna Sirip Kuning', 'kategori' => 'Ikan'],
        ['nama' => 'Layang', 'kategori' => 'Ikan'],
        ['nama' => 'Selar', 'kategori' => 'Ikan'],
        ['nama' => 'Bandeng', 'kategori' => 'Ikan'],
        ['nama' => 'Cakalang', 'kategori' => 'Ikan'],
        ['nama' => 'Baronang', 'kategori' => 'Ikan'],
        ['nama' => 'Ekor Kuning', 'kategori' => 'Ikan'],
        ['nama' => 'Giant Trevally (GT)', 'kategori' => 'Ikan'],
        // Udang
        ['nama' => 'Udang Vaname', 'kategori' => 'Udang'],
        ['nama' => 'Lobster', 'kategori' => 'Udang'],
        // Kepiting
        ['nama' => 'Rajungan', 'kategori' => 'Kepiting'],
        ['nama' => 'Kepiting Bakau', 'kategori' => 'Kepiting'],
        // Cumi & Gurita
        ['nama' => 'Gurita', 'kategori' => 'Cumi & Gurita'],
        ['nama' => 'Cumi-cumi', 'kategori' => 'Cumi & Gurita'],
    ];

    // Contoh nama daerah/alias - buat demo fitur tag, tidak wajib lengkap.
    private array $tagContoh = [
        'Giant Trevally (GT)' => ['Ikan Gabui', 'Ikan Kuwe'],
        'Kakaktua' => ['Ikan Bebek'],
    ];

    public function run(): void
    {
        $admin = User::role('Admin')->first();

        // Kategori dibuat dulu (unique per nama), baru komoditi mereferensikannya via FK.
        $kategoriIdByNama = collect($this->daftarKomoditi)
            ->pluck('kategori')
            ->unique()
            ->mapWithKeys(function ($nama) {
                $kategori = KategoriKomoditi::firstOrCreate(['nama' => $nama]);
                return [$nama => $kategori->id];
            });

        foreach ($this->daftarKomoditi as $item) {
            $komoditi = Komoditi::firstOrCreate(
                ['nama' => $item['nama']],
                [
                    'kategori_id' => $kategoriIdByNama[$item['kategori']],
                    'status' => 'disetujui',
                    'diusulkan_oleh' => $admin?->id,
                    'approved_by' => $admin?->id,
                ]
            );

            foreach ($this->tagContoh[$item['nama']] ?? [] as $namaTag) {
                $komoditi->tags()->firstOrCreate(
                    ['nama_tag' => $namaTag],
                    ['ditambahkan_oleh' => $admin?->id]
                );
            }
        }

        $this->command->info(count($this->daftarKomoditi) . ' komoditi master berhasil dibuat, dengan ' . $kategoriIdByNama->count() . ' kategori.');
    }
}
