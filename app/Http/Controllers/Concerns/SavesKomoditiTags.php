<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Komoditi;
use App\Models\KomoditiTag;
use Illuminate\Support\Facades\Auth;

// Dipakai bareng oleh PenawaranController & PermintaanController - keduanya sekarang
// punya field "Nama Ikan Lainnya" (nama_tag komoditi) langsung di form, tanpa harus
// ke halaman Kelola Nama Ikan Lainnya terpisah.
trait SavesKomoditiTags
{
    // Peta komoditi_id => daftar nama tag yang SUDAH ada, dikirim ke JS supaya select2
    // "Nama Ikan Lainnya" otomatis terisi ulang begitu Komoditi diganti.
    protected function tagsByKomoditiJson(): string
    {
        return Komoditi::disetujui()
            ->with('tags')
            ->get()
            ->mapWithKeys(fn ($k) => [$k->id => $k->tags->pluck('nama_tag')->values()])
            ->toJson();
    }

    // Simpan tag baru yang diketik user langsung di form Penawaran/Permintaan.
    // SENGAJA hanya menambah (bukan menghapus) - kalau user "melepas" chip yang tadinya
    // sudah ada, itu tidak menghapus tag asli komoditi (biar tidak ada efek samping
    // destruktif dari form yang niatnya cuma posting Penawaran/Permintaan).
    // Duplikat dicek case-insensitive supaya "Kerapu sunu" tidak dobel sama "Kerapu Sunu".
    protected function simpanTagBaruKomoditi(?int $komoditiId, array $tagList): void
    {
        if (! $komoditiId || empty($tagList)) {
            return;
        }

        $sudahAda = KomoditiTag::where('komoditi_id', $komoditiId)
            ->pluck('nama_tag')
            ->map(fn ($t) => mb_strtolower(trim($t)))
            ->all();

        foreach ($tagList as $tag) {
            $tag = trim((string) $tag);

            if ($tag === '' || in_array(mb_strtolower($tag), $sudahAda, true)) {
                continue;
            }

            KomoditiTag::create([
                'komoditi_id' => $komoditiId,
                'nama_tag' => $tag,
                'ditambahkan_oleh' => Auth::id(),
            ]);

            // Supaya kalau ada 2 tag baru yang sama persis di array (mis. ketik dobel
            // tanpa sengaja), tidak ikut disimpan 2 kali dalam request yang sama.
            $sudahAda[] = mb_strtolower($tag);
        }
    }
}
