<?php

namespace Database\Seeders;

use App\Models\KategoriKomoditi;
use App\Models\Komoditi;
use App\Models\User;
use Illuminate\Database\Seeder;

class KomoditiSeeder extends Seeder
{
    private array $daftarKomoditi = [

        // =========================================================
        // IKAN
        // =========================================================

        [
            'nama' => 'Kembung Kuring',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Tongkol',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Tenggiri',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Kakap Merah',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Kerapu Sunu',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Kerapu Tiger',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Kerapu Nanas',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Kakaktua',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Bawal',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Tuna Sirip Kuning',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Layang',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Selar',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Bandeng',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Cakalang',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Baronang',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Ekor Kuning',
            'kategori' => 'Ikan',
        ],
        [
            'nama' => 'Giant Trevally (GT)',
            'kategori' => 'Ikan',
        ],

        // =========================================================
        // UDANG
        // =========================================================

        [
            'nama' => 'Udang Vaname',
            'kategori' => 'Udang',
        ],
        [
            'nama' => 'Lobster',
            'kategori' => 'Udang',
        ],

        // =========================================================
        // KEPITING
        // =========================================================

        [
            'nama' => 'Rajungan',
            'kategori' => 'Kepiting',
        ],
        [
            'nama' => 'Kepiting Bakau',
            'kategori' => 'Kepiting',
        ],

        // =========================================================
        // CUMI & GURITA
        // =========================================================

        [
            'nama' => 'Giant Octopus',
            'kategori' => 'Cumi & Gurita',
        ],
        [
            'nama' => 'Baby Octopus',
            'kategori' => 'Cumi & Gurita',
        ],
        [
            'nama' => 'Cumi Jantung',
            'kategori' => 'Cumi & Gurita',
        ],
    ];

    /**
     * Nama lain / nama daerah / nama pasar / nama Inggris
     * untuk masing-masing komoditi.
     */
    private array $tagKomoditi = [

        // =========================================================
        // IKAN
        // =========================================================

        'Kembung Kuring' => [
            'Kembung Kuring',
            'Kembung',
            'Kembung Perempuan',
            'Kembung Bini',
            'Indian Mackerel',
            'Short-bodied Mackerel',
            'Rastrelliger brachysoma',
        ],

        'Tongkol' => [
            'Tongkol',
            'Tongkol Komo',
            'Tongkol Cino',
            'Tongkol Abu-abu',
            'Kawakawa',
            'Little Tuna',
            'Euthynnus affinis',
        ],

        'Tenggiri' => [
            'Tenggiri',
            'Tengiri',
            'Tenggiri Papan',
            'Tenggiri Batang',
            'Tenggiri Telayu',
            'Spanish Mackerel',
            'Narrow-barred Spanish Mackerel',
            'King Mackerel',
            'Scomberomorus commerson',
        ],

        'Kakap Merah' => [
            'Kakap Merah',
            'Kakap',
            'Bambangan',
            'Bambang',
            'Darongan',
            'Kellet',
            'Posepa',
            'Bran',
            'Bran-bran',
            'Langgaria',
            'Gacak',
            'Bacan',
            'Delise',
            'Lolise',
            'Delis',
            'Sengaru',
            'Red Snapper',
            'Mangrove Red Snapper',
            'Mangrove Jack',
            'Lutjanus argentimaculatus',
        ],

        // ---------------------------------------------------------
        // KERAPU SUNU
        // ---------------------------------------------------------

        'Kerapu Sunu' => [
            'Ikan Janang',
            'Kerapu Sunu',
            'Sunu',
            'Kerapu Merah',
            'Kerapu Sunu Merah',
            'Coral Trout',
            'Coral Grouper',
            'Red Coral Grouper',
            'Plectropomus leopardus',
        ],

        // ---------------------------------------------------------
        // KERAPU TIGER
        // ---------------------------------------------------------

        'Kerapu Tiger' => [
            'Kerapu Macan',
            'Kerapu Harimau',
            'Kerapu Loreng',
            'Tiger Grouper',
            'Brown-spotted Grouper',
            'Flowery Grouper',
            'Epinephelus fuscoguttatus',
        ],

        // ---------------------------------------------------------
        // KERAPU NANAS
        // ---------------------------------------------------------

        'Kerapu Nanas' => [
            'Kerapu Sawai',
            'Kerapu Ekor Kuning',
            'Kerapu Ekor Gunting',
            'Yellowtail Grouper',
            'Yellowtail Rockcod',
        ],

        'Kakaktua' => [
            'Ikan Fal-fal',
            'Ikan Bayam',
            'Ikan Kakatua',
            'Kakaktua Laut',
            'Parrotfish',
            'Parrot Fish',
        ],

        'Bawal' => [
            'Bawal Putih',
            'Bawal Cermin',
            'Bawal Tambak',
            'White Pomfret',
            'Silver Pomfret',
        ],

        'Tuna Sirip Kuning' => [
            'Sirip Kuning',
            'Madidihang',
            'Madidihang Tuna',
            'Yellowfin Tuna',
            'Yellowfin',
            'Pani-pani',
            'Bengkunis',
            'Bangkuni',
            'Thunnus albacares',
        ],

        'Layang' => [
            'Meong-meong',
            'Ikan Layang',
            'Layang Benggol',
            'Layang Deles',
            'Layang Biru',
            'Indian Scad',
            'Scad',
            'Decapterus',
        ],

        'Selar' => [
            'Selar',
            'Ikan Selar',
            'Selar Kuning',
            'Selar Kuning Hijau',
            'Yellowstripe Scad',
            'Yellowstripe Trevally',
            'Selaroides leptolepis',
        ],

        'Bandeng' => [
            'Bandeng',
            'Ikan Bandeng',
            'Bolou',
            'Milkfish',
            'Chanos chanos',
        ],

        'Cakalang' => [
            'Timpik',
            'Ikan Cakalang',
            'Cakalang Fufu',
            'Skipjack',
            'Skipjack Tuna',
            'Katsuwonus',
            'Katsuwonus pelamis',
        ],

        'Baronang' => [
            'Baronang Susu',
            'Baronang Lingkis',
            'Baronang Angin',
            'Rabbitfish',
            'Spinefoot',
        ],

        'Ekor Kuning' => [
            'Ikan Ekor Kuning',
            'Delah',
            'Caesio Cuning',
            'Yellowtail Fusilier',
            'Yellowtail Fusilier Fish',
            'Caesio cuning',
        ],

        'Giant Trevally (GT)' => [
            'GT',
            'Ikan GT',
            'Kuwe Gerong',
            'Kuwe',
            'Gerong',
            'Bubara',
            'Belitong',
            'Gabui',
            'Giant Kingfish',
            'Caranx ignobilis',
        ],

        // =========================================================
        // UDANG
        // =========================================================

        'Udang Vaname' => [
            'Vaname',
            'Udang Putih',
            'White Shrimp',
            'Whiteleg Shrimp',
            'Pacific White Shrimp',
            'Pacific Whiteleg Shrimp',
            'Litopenaeus vannamei',
        ],

        'Lobster' => [
            'Udang Lobster',
            'Udang Karang',
            'Udang Barong',
            'Spiny Lobster',
            'Rock Lobster',
        ],

        // =========================================================
        // KEPITING
        // =========================================================

        'Rajungan' => [
            'Kepiting Rajungan',
            'Rajungan Biru',
            'Blue Swimming Crab',
            'Swimming Crab',
            'Blue Crab',
            'Portunus pelagicus',
        ],

        'Kepiting Bakau' => [
            'Kepiting Lumpur',
            'Kepiting Mangrove',
            'Mangrove Crab',
            'Mud Crab',
            'Kepiting Batu',
            'Scylla',
            'Scylla serrata',
        ],

        // =========================================================
        // CUMI & GURITA
        // =========================================================

        'Octopus (Gurita)' => [
            'Gurita Besar',
            'Gurita Raksasa',
            'Gurita',
            'Gurita Kaki Panjang',
            'Octopus',
        ],

        'Baby Octopus' => [
            'Baby Gurita',
            'Bayi Gurita',
            'Gurita Kecil',
            'Gurita Kaki Pendek',
            'Gurita Kaki Kecil',
            'Gurita Muda',
            'Gurita Mini',
            'Small Octopus',
            'Young Octopus',
        ],

        'Cumi Jantung' => [
            'Cumi-cumi Jantung',
            'Cumi Jantung-jantung',
            'Heart Squid',
        ],
    ];

    public function run(): void
    {
        $admin = User::role('Admin')->first();

        // Kategori dibuat dulu
        $kategoriIdByNama = collect($this->daftarKomoditi)
            ->pluck('kategori')
            ->unique()
            ->mapWithKeys(function ($nama) {
                $kategori = KategoriKomoditi::firstOrCreate([
                    'nama' => $nama,
                ]);

                return [$nama => $kategori->id];
            });

        // Komoditi + tag
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

            foreach ($this->tagKomoditi[$item['nama']] ?? [] as $namaTag) {

                $komoditi->tags()->firstOrCreate(
                    ['nama_tag' => $namaTag],
                    [
                        'ditambahkan_oleh' => $admin?->id,
                    ]
                );
            }
        }

        $totalTag = collect($this->tagKomoditi)
            ->flatten()
            ->unique()
            ->count();

        $this->command->info(
            count($this->daftarKomoditi)
                . ' komoditi master berhasil dibuat, dengan '
                . $kategoriIdByNama->count()
                . ' kategori dan '
                . $totalTag
                . ' tag.'
        );
    }
}
