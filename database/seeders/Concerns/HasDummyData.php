<?php

namespace Database\Seeders\Concerns;

trait HasDummyData
{
    protected array $jenisIkan = [
        'Kembung Kuring', 'Tongkol', 'Tenggiri', 'Kakap Merah', 'Kerapu',
        'Gurita', 'Cumi-cumi', 'Udang Vaname', 'Kakaktua', 'Bawal',
        'Tuna Sirip Kuning', 'Layang', 'Selar', 'Bandeng', 'Rajungan',
        'Cakalang', 'Baronang', 'Ekor Kuning', 'Kepiting Bakau', 'Lobster',
    ];

    protected array $kondisiIkan = ['Segar', 'Beku', 'Segar - Baru Ditangkap', 'Beku - Cold Storage'];

    protected array $negaraTujuan = ['Jepang', 'China', 'Amerika Serikat', 'Korea Selatan', 'Uni Eropa', 'Malaysia', 'Singapura'];

    protected array $grading = ['A', 'B', 'Super', 'Premium', 'Grade Ekspor 1', 'Grade Ekspor 2'];

    protected array $sertifikasi = ['HACCP', 'MSC', 'BRC', 'HACCP + MSC', null];

    protected function jenisIkanAcak(): string
    {
        return $this->jenisIkan[array_rand($this->jenisIkan)];
    }

    protected function kondisiIkanAcak(): string
    {
        return $this->kondisiIkan[array_rand($this->kondisiIkan)];
    }

    protected function negaraTujuanAcak(): string
    {
        return $this->negaraTujuan[array_rand($this->negaraTujuan)];
    }

    protected function gradingAcak(): string
    {
        return $this->grading[array_rand($this->grading)];
    }

    protected function sertifikasiAcak(): ?string
    {
        return $this->sertifikasi[array_rand($this->sertifikasi)];
    }

    protected function nomorWhatsapp(): string
    {
        return '08' . rand(11, 99) . rand(1000000, 9999999);
    }

    protected function kontinuitasAcak(): string
    {
        $opsi = [
            'Rutin tiap minggu, kapasitas stabil',
            'Musiman, tergantung hasil tangkapan',
            'Bisa kontinu jika ada kepastian pembeli',
            'Rutin 2 minggu sekali',
        ];

        return $opsi[array_rand($opsi)];
    }

    protected function namaPTAcak(): string
    {
        $opsi = ['Sumber Laut Jaya', 'Nusantara Bahari', 'Cipta Samudra', 'Mitra Perikanan Indonesia', 'Bahari Sejahtera'];

        return $opsi[array_rand($opsi)];
    }

    protected function tagPrioritasAcak(): string
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
