<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\User;
use Database\Seeders\Concerns\HasDummyData;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use HasDummyData;

    private array $namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lestari', 'Made', 'Nur', 'Oki', 'Putri', 'Rahmat', 'Sari', 'Taufik', 'Umar', 'Vina', 'Wawan', 'Yanto', 'Zainal'];

    private array $namaBelakang = ['Saputra', 'Wijaya', 'Kusuma', 'Pratama', 'Santoso', 'Nugroho', 'Handoko', 'Permana', 'Utami', 'Siregar'];

    public function run(): void
    {
        // Membutuhkan RoleSeeder dan CabangSeeder sudah dijalankan lebih dulu.
        $cabangList = Cabang::all();

        if ($cabangList->isEmpty()) {
            $this->command->warn('Belum ada data Cabang. Jalankan CabangSeeder terlebih dahulu.');
            return;
        }

        $this->buatAdmin();
        $this->buatPusat();
        $this->buatUserCabang($cabangList);
    }

    private function buatAdmin(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@fpt.test'],
            [
                'name' => 'Admin Sistem',
                'password' => bcrypt('perindo'),
                'cabang_id' => null,
                'no_whatsapp' => $this->nomorWhatsapp(),
            ]
        );
        $admin->assignRole('Admin');

        $this->command->info('1 user Admin berhasil dibuat.');
    }

    private function buatPusat(): void
    {
        $namaPusat = ['Ramous Peppy', 'Robertto', 'Muhammad Alpanda'];

        foreach ($namaPusat as $i => $nama) {
            $user = User::firstOrCreate(
                ['email' => 'pusat' . ($i + 1) . '@fpt.test'],
                [
                    'name' => $nama,
                    'password' => bcrypt('perindo'),
                    'cabang_id' => null,
                    'no_whatsapp' => $this->nomorWhatsapp(),
                ]
            );
            $user->assignRole('Pusat');
        }

        $this->command->info(count($namaPusat) . ' user Pusat berhasil dibuat.');
    }

    private function buatUserCabang($cabangList): void
    {
        $jumlahDibuat = 0;

        foreach ($cabangList as $cabang) {
            $jumlahUser = rand(1, 2);

            for ($i = 0; $i < $jumlahUser; $i++) {
                $nama = $this->namaDepan[array_rand($this->namaDepan)] . ' ' . $this->namaBelakang[array_rand($this->namaBelakang)];
                $email = 'cabang' . $cabang->id . '_' . ($i + 1) . '@fpt.test';

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $nama,
                        'password' => bcrypt('perindo'),
                        'cabang_id' => $cabang->id,
                        'no_whatsapp' => $this->nomorWhatsapp(),
                    ]
                );
                $user->assignRole('Cabang');
                $jumlahDibuat++;
            }
        }

        $this->command->info("{$jumlahDibuat} user Cabang berhasil dibuat.");
    }
}
