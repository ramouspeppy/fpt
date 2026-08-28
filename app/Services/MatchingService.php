<?php

namespace App\Services;

use App\Models\MatchSuggestion;
use App\Models\Penawaran;
use App\Models\PenawaranRincianGrade;
use App\Models\Permintaan;
use App\Models\PermintaanRincianGrade;
use Illuminate\Support\Collection;

class MatchingService
{
    /**
     * Cari kandidat baris rincian Permintaan yang cocok untuk SEMUA baris rincian
     * milik 1 Penawaran, lalu simpan sebagai MatchSuggestion (per pasangan baris grade).
     */
    public function generateForPenawaran(Penawaran $penawaran): Collection
    {
        if ($penawaran->status !== 'tersedia') {
            return collect();
        }

        $hasil = collect();

        foreach ($penawaran->rincianGrade as $rincianPenawaran) {
            $kandidat = PermintaanRincianGrade::with(['permintaan.user.cabang'])
                ->whereRaw('LOWER(ukuran_grade) = ?', [mb_strtolower(trim($rincianPenawaran->ukuran_grade))])
                ->whereHas('permintaan', function ($q) use ($penawaran) {
                    $q->where('status', 'tersedia')
                      ->where('user_id', '!=', $penawaran->user_id)
                      ->whereRaw('LOWER(jenis_ikan) = ?', [mb_strtolower($penawaran->jenis_ikan)]);
                })
                ->get()
                ->filter(fn (PermintaanRincianGrade $r) => $this->tipeCocok($penawaran->tipe, $r->permintaan->tipe))
                ->filter(fn (PermintaanRincianGrade $r) => $this->cabangBerbeda($penawaran->user, $r->permintaan->user));

            foreach ($kandidat as $rincianPermintaan) {
                $match = $this->simpanJikaBelumAda($penawaran, $rincianPenawaran, $rincianPermintaan->permintaan, $rincianPermintaan);
                if ($match) {
                    $hasil->push($match);
                }
            }
        }

        return $hasil;
    }

    /**
     * Kebalikan dari generateForPenawaran: dipicu setelah Permintaan baru dibuat.
     */
    public function generateForPermintaan(Permintaan $permintaan): Collection
    {
        if ($permintaan->status !== 'tersedia') {
            return collect();
        }

        $hasil = collect();

        foreach ($permintaan->rincianGrade as $rincianPermintaan) {
            $kandidat = PenawaranRincianGrade::with(['penawaran.user.cabang'])
                ->whereRaw('LOWER(ukuran_grade) = ?', [mb_strtolower(trim($rincianPermintaan->ukuran_grade))])
                ->whereHas('penawaran', function ($q) use ($permintaan) {
                    $q->where('status', 'tersedia')
                      ->where('user_id', '!=', $permintaan->user_id)
                      ->whereRaw('LOWER(jenis_ikan) = ?', [mb_strtolower($permintaan->jenis_ikan)]);
                })
                ->get()
                ->filter(fn (PenawaranRincianGrade $r) => $this->tipeCocok($r->penawaran->tipe, $permintaan->tipe))
                ->filter(fn (PenawaranRincianGrade $r) => $this->cabangBerbeda($r->penawaran->user, $permintaan->user));

            foreach ($kandidat as $rincianPenawaran) {
                $match = $this->simpanJikaBelumAda($rincianPenawaran->penawaran, $rincianPenawaran, $permintaan, $rincianPermintaan);
                if ($match) {
                    $hasil->push($match);
                }
            }
        }

        return $hasil;
    }

    /**
     * Scan ulang SEMUA penawaran yang masih "tersedia". Untuk backfill data lama
     * atau tombol "Cari Kecocokan Ulang".
     */
    public function runAll(): int
    {
        $jumlah = 0;

        Penawaran::where('status', 'tersedia')->with('rincianGrade')->each(function (Penawaran $penawaran) use (&$jumlah) {
            $jumlah += $this->generateForPenawaran($penawaran)->count();
        });

        return $jumlah;
    }

    // ------------------------------------------------------------------
    // Aturan pencocokan
    // ------------------------------------------------------------------

    private function tipeCocok(string $tipePenawaran, string $tipePermintaan): bool
    {
        if ($tipePenawaran === 'Ekspor & Lokal') {
            return in_array($tipePermintaan, ['Ekspor', 'Lokal']);
        }

        return $tipePenawaran === $tipePermintaan;
    }

    // "lokasi cocok" disederhanakan jadi "bukan dari cabang yang sama"
    private function cabangBerbeda($userPenawaran, $userPermintaan): bool
    {
        if (is_null($userPenawaran->cabang_id) || is_null($userPermintaan->cabang_id)) {
            return true;
        }

        return $userPenawaran->cabang_id !== $userPermintaan->cabang_id;
    }

    private function apakahMatchIniEkspor(Penawaran $penawaran, Permintaan $permintaan): bool
    {
        return $penawaran->mengandungEkspor() && $permintaan->isEkspor();
    }

    // Skor 0-100 berdasarkan kemiripan kuantiti antar baris grade yang cocok
    private function hitungSkor(PenawaranRincianGrade $rincianPenawaran, PermintaanRincianGrade $rincianPermintaan, bool $iniEkspor): float
    {
        $skor = 50; // base: jenis ikan, tipe, dan grade sudah pasti cocok (syarat mutlak)

        $kecil = min($rincianPenawaran->kuantiti, $rincianPermintaan->kuantiti);
        $besar = max($rincianPenawaran->kuantiti, $rincianPermintaan->kuantiti);
        $rasioKuantiti = $besar > 0 ? ($kecil / $besar) : 0;
        $skor += $rasioKuantiti * 30;

        if ($iniEkspor) {
            $skor += 20;
        }

        return round(min($skor, 100), 2);
    }

    private function simpanJikaBelumAda(
        Penawaran $penawaran,
        PenawaranRincianGrade $rincianPenawaran,
        Permintaan $permintaan,
        PermintaanRincianGrade $rincianPermintaan
    ): ?MatchSuggestion {
        // hindari duplikat pasangan BARIS GRADE yang sama (kecuali sebelumnya ditolak, boleh dicoba ulang)
        $sudahAda = MatchSuggestion::where('penawaran_rincian_id', $rincianPenawaran->id)
            ->where('permintaan_rincian_id', $rincianPermintaan->id)
            ->where('status', '!=', 'ditolak')
            ->exists();

        if ($sudahAda) {
            return null;
        }

        $iniEkspor = $this->apakahMatchIniEkspor($penawaran, $permintaan);

        return MatchSuggestion::create([
            'penawaran_id' => $penawaran->id,
            'permintaan_id' => $permintaan->id,
            'penawaran_rincian_id' => $rincianPenawaran->id,
            'permintaan_rincian_id' => $rincianPermintaan->id,
            'skor_matching' => $this->hitungSkor($rincianPenawaran, $rincianPermintaan, $iniEkspor),
            // ekspor -> wajib direview pusat (menunggu_review); lokal/biasa -> notifikasi_otomatis (sistem yang temukan, TANPA approval manusia)
            'status' => $iniEkspor ? 'menunggu_review' : 'notifikasi_otomatis',
        ]);
    }
}
