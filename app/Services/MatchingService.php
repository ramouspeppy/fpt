<?php

namespace App\Services;

use App\Models\MatchSuggestion;
use App\Models\Penawaran;
use App\Models\Permintaan;
use Illuminate\Support\Collection;

class MatchingService
{
    /**
     * Cari kandidat Permintaan yang cocok untuk 1 Penawaran, lalu simpan sebagai MatchSuggestion.
     * Dipanggil otomatis setelah Penawaran baru dibuat.
     */
    public function generateForPenawaran(Penawaran $penawaran): Collection
    {
        if ($penawaran->status !== 'tersedia') {
            return collect();
        }

        $kandidat = Permintaan::with('detailEkspor')
            ->where('status', 'tersedia')
            ->where('user_id', '!=', $penawaran->user_id) // tidak match ke permintaan dari user yang sama
            ->whereRaw('LOWER(jenis_ikan) = ?', [mb_strtolower($penawaran->jenis_ikan)])
            ->get()
            ->filter(fn (Permintaan $permintaan) => $this->tipeCocok($penawaran->tipe, $permintaan->tipe))
            ->filter(fn (Permintaan $permintaan) => $this->cabangBerbeda($penawaran, $permintaan));

        $hasil = collect();

        foreach ($kandidat as $permintaan) {
            $match = $this->simpanJikaBelumAda($penawaran, $permintaan);
            if ($match) {
                $hasil->push($match);
            }
        }

        return $hasil;
    }

    /**
     * Cari kandidat Penawaran yang cocok untuk 1 Permintaan, lalu simpan sebagai MatchSuggestion.
     * Dipanggil otomatis setelah Permintaan baru dibuat.
     */
    public function generateForPermintaan(Permintaan $permintaan): Collection
    {
        if ($permintaan->status !== 'tersedia') {
            return collect();
        }

        $kandidat = Penawaran::with('detailEkspor')
            ->where('status', 'tersedia')
            ->where('user_id', '!=', $permintaan->user_id)
            ->whereRaw('LOWER(jenis_ikan) = ?', [mb_strtolower($permintaan->jenis_ikan)])
            ->get()
            ->filter(fn (Penawaran $penawaran) => $this->tipeCocok($penawaran->tipe, $permintaan->tipe))
            ->filter(fn (Penawaran $penawaran) => $this->cabangBerbeda($penawaran, $permintaan));

        $hasil = collect();

        foreach ($kandidat as $penawaran) {
            $match = $this->simpanJikaBelumAda($penawaran, $permintaan);
            if ($match) {
                $hasil->push($match);
            }
        }

        return $hasil;
    }

    /**
     * Scan ulang SEMUA penawaran & permintaan yang masih "tersedia".
     * Berguna untuk backfill data lama (sebelum fitur ini ada) atau tombol "Cari Kecocokan Ulang".
     */
    public function runAll(): int
    {
        $jumlah = 0;

        Penawaran::where('status', 'tersedia')->each(function (Penawaran $penawaran) use (&$jumlah) {
            $jumlah += $this->generateForPenawaran($penawaran)->count();
        });

        return $jumlah;
    }

    // ------------------------------------------------------------------
    // Aturan pencocokan
    // ------------------------------------------------------------------

    /**
     * Tipe cocok jika:
     * - Penawaran "Lokal" hanya cocok ke Permintaan "Lokal"
     * - Penawaran "Ekspor" hanya cocok ke Permintaan "Ekspor"
     * - Penawaran "Ekspor & Lokal" cocok ke Permintaan "Ekspor" ATAU "Lokal"
     */
    private function tipeCocok(string $tipePenawaran, string $tipePermintaan): bool
    {
        if ($tipePenawaran === 'Ekspor & Lokal') {
            return in_array($tipePermintaan, ['Ekspor', 'Lokal']);
        }

        return $tipePenawaran === $tipePermintaan;
    }

    // Untuk versi ini, "lokasi cocok" disederhanakan jadi "bukan dari cabang yang sama"
    // (belum ada perhitungan jarak/koordinat antar cabang).
    private function cabangBerbeda(Penawaran $penawaran, Permintaan $permintaan): bool
    {
        $cabangPenawaran = $penawaran->user->cabang_id;
        $cabangPermintaan = $permintaan->user->cabang_id;

        // jika salah satu tidak terikat cabang (mis. user Pusat), anggap boleh match
        if (is_null($cabangPenawaran) || is_null($cabangPermintaan)) {
            return true;
        }

        return $cabangPenawaran !== $cabangPermintaan;
    }

    // Untuk match ekspor, grading wajib sama (syarat mutlak tambahan)
    private function gradingCocokUntukEkspor(Penawaran $penawaran, Permintaan $permintaan): bool
    {
        if (! $penawaran->mengandungEkspor() || ! $permintaan->isEkspor()) {
            return true; // bukan kasus ekspor, tidak relevan
        }

        $gradingPenawaran = $penawaran->detailEkspor->grading ?? null;
        $gradingPermintaan = $permintaan->detailEkspor->grading ?? null;

        if (! $gradingPenawaran || ! $gradingPermintaan) {
            return false; // data ekspor belum lengkap, jangan di-auto-match dulu
        }

        return mb_strtolower(trim($gradingPenawaran)) === mb_strtolower(trim($gradingPermintaan));
    }

    private function apakahMatchIniEkspor(Penawaran $penawaran, Permintaan $permintaan): bool
    {
        return $penawaran->mengandungEkspor() && $permintaan->isEkspor();
    }

    // Skor 0-100, dipakai untuk mengurutkan relevansi di halaman daftar match
    private function hitungSkor(Penawaran $penawaran, Permintaan $permintaan): float
    {
        $skor = 50; // base: jenis ikan & tipe sudah pasti cocok (syarat mutlak)

        // kemiripan volume: makin dekat volume penawaran & permintaan, makin tinggi skor
        $volumeKecil = min($penawaran->volume, $permintaan->volume);
        $volumeBesar = max($penawaran->volume, $permintaan->volume);
        $rasioVolume = $volumeBesar > 0 ? ($volumeKecil / $volumeBesar) : 0;
        $skor += $rasioVolume * 30;

        // bonus tambahan untuk match ekspor yang grading-nya cocok
        if ($this->apakahMatchIniEkspor($penawaran, $permintaan)) {
            $skor += 20;
        }

        return round(min($skor, 100), 2);
    }

    private function simpanJikaBelumAda(Penawaran $penawaran, Permintaan $permintaan): ?MatchSuggestion
    {
        // untuk kasus ekspor, grading wajib sama - kalau tidak, jangan buat suggestion
        if (! $this->gradingCocokUntukEkspor($penawaran, $permintaan)) {
            return null;
        }

        // hindari duplikat pasangan yang sama (kecuali sebelumnya ditolak, boleh dicoba ulang)
        $sudahAda = MatchSuggestion::where('penawaran_id', $penawaran->id)
            ->where('permintaan_id', $permintaan->id)
            ->where('status', '!=', 'ditolak')
            ->exists();

        if ($sudahAda) {
            return null;
        }

        $iniEkspor = $this->apakahMatchIniEkspor($penawaran, $permintaan);

        return MatchSuggestion::create([
            'penawaran_id' => $penawaran->id,
            'permintaan_id' => $permintaan->id,
            'skor_matching' => $this->hitungSkor($penawaran, $permintaan),
            // ekspor -> wajib direview pusat; lokal/biasa -> langsung disetujui (notifikasi otomatis)
            'status' => $iniEkspor ? 'menunggu_review' : 'disetujui',
        ]);
    }
}
