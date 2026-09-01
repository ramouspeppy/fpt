<?php

namespace Database\Seeders;

use App\Models\Komoditi;
use App\Models\User;
use Illuminate\Database\Seeder;

class KomoditiSizeSeeder extends Seeder
{
    // Sama untuk semua komoditi supaya dummy data sederhana - di dunia nyata tiap
    // komoditi bisa punya daftar size yang beda persis (itu tujuan tabel ini dibuat).
    // Urutan pakai gap numbering (10, 20, 30, 40) supaya nanti bisa disisipi size
    // baru (mis. "2000UP" di atas "1000UP") tanpa geser ulang semua data.
    private array $daftarSize = [
        ['nama_size' => '1000UP', 'urutan' => 10],
        ['nama_size' => '500-1000', 'urutan' => 20],
        ['nama_size' => '300-500', 'urutan' => 30],
        ['nama_size' => '200-300', 'urutan' => 40],
    ];

    public function run(): void
    {
        $admin = User::role('Admin')->first();
        $komoditiList = Komoditi::disetujui()->get();

        if ($komoditiList->isEmpty()) {
            $this->command->warn('Belum ada master data Komoditi. Jalankan KomoditiSeeder terlebih dahulu.');
            return;
        }

        $jumlah = 0;

        foreach ($komoditiList as $komoditi) {
            foreach ($this->daftarSize as $size) {
                $komoditi->sizes()->firstOrCreate(
                    ['nama_size' => $size['nama_size']],
                    [
                        'urutan' => $size['urutan'],
                        'status' => 'disetujui',
                        'diusulkan_oleh' => $admin?->id,
                        'approved_by' => $admin?->id,
                    ]
                );
                $jumlah++;
            }
        }

        $this->command->info("{$jumlah} baris komoditi_size berhasil dibuat.");
    }
}
