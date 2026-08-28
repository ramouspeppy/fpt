<?php

namespace Database\Seeders;

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

    public function run(): void
    {
        // Data awal ini dianggap sudah "resmi" dari sistem (bukan usulan cabang), jadi langsung disetujui.
        $admin = User::role('Admin')->first();

        foreach ($this->daftarKomoditi as $item) {
            Komoditi::firstOrCreate(
                ['nama' => $item['nama']],
                [
                    'kategori' => $item['kategori'],
                    'status' => 'disetujui',
                    'diusulkan_oleh' => $admin?->id,
                    'approved_by' => $admin?->id,
                ]
            );
        }

        $this->command->info(count($this->daftarKomoditi) . ' komoditi master berhasil dibuat.');
    }
}
