<?php

namespace App\Services;

use App\Models\MatchSuggestion;
use App\Models\Penawaran;
use App\Models\PenawaranRincianSize;
use App\Models\Permintaan;
use App\Models\PermintaanRincianSize;
use Illuminate\Support\Collection;

class MatchingService
{
    public function generateForPenawaran(Penawaran $penawaran): Collection
    {
        if ($penawaran->status !== 'tersedia' || ! $penawaran->komoditi_id) {
            return collect();
        }

        $hasil = collect();

        foreach ($penawaran->rincianSize as $rincianPenawaran) {
            if (! $rincianPenawaran->komoditi_size_id) {
                continue;
            }

            $kandidat = PermintaanRincianSize::with(['permintaan.user.cabang'])
                ->where('komoditi_size_id', $rincianPenawaran->komoditi_size_id) // SIZE SAMA PERSIS (ID), bukan lagi teks
                ->whereHas('permintaan', function ($q) use ($penawaran) {
                    $q->where('status', 'tersedia')
                      ->where('user_id', '!=', $penawaran->user_id)
                      ->where('komoditi_id', $penawaran->komoditi_id); // KOMODITI SAMA PERSIS
                })
                ->get()
                ->filter(fn (PermintaanRincianSize $r) => $this->tipeCocok($penawaran->tipe, $r->permintaan->tipe))
                ->filter(fn (PermintaanRincianSize $r) => $this->cabangBerbeda($penawaran->user, $r->permintaan->user));

            foreach ($kandidat as $rincianPermintaan) {
                $match = $this->simpanJikaBelumAda($penawaran, $rincianPenawaran, $rincianPermintaan->permintaan, $rincianPermintaan);
                if ($match) {
                    $hasil->push($match);
                }
            }
        }

        return $hasil;
    }

    public function generateForPermintaan(Permintaan $permintaan): Collection
    {
        if ($permintaan->status !== 'tersedia' || ! $permintaan->komoditi_id) {
            return collect();
        }

        $hasil = collect();

        foreach ($permintaan->rincianSize as $rincianPermintaan) {
            if (! $rincianPermintaan->komoditi_size_id) {
                continue;
            }

            $kandidat = PenawaranRincianSize::with(['penawaran.user.cabang'])
                ->where('komoditi_size_id', $rincianPermintaan->komoditi_size_id)
                ->whereHas('penawaran', function ($q) use ($permintaan) {
                    $q->where('status', 'tersedia')
                      ->where('user_id', '!=', $permintaan->user_id)
                      ->where('komoditi_id', $permintaan->komoditi_id);
                })
                ->get()
                ->filter(fn (PenawaranRincianSize $r) => $this->tipeCocok($r->penawaran->tipe, $permintaan->tipe))
                ->filter(fn (PenawaranRincianSize $r) => $this->cabangBerbeda($r->penawaran->user, $permintaan->user));

            foreach ($kandidat as $rincianPenawaran) {
                $match = $this->simpanJikaBelumAda($rincianPenawaran->penawaran, $rincianPenawaran, $permintaan, $rincianPermintaan);
                if ($match) {
                    $hasil->push($match);
                }
            }
        }

        return $hasil;
    }

    public function runAll(): int
    {
        $jumlah = 0;

        Penawaran::where('status', 'tersedia')->with('rincianSize')->each(function (Penawaran $penawaran) use (&$jumlah) {
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

    private function cabangBerbeda($userPenawaran, $userPermintaan): bool
    {
        if (is_null($userPenawaran->cabang_id) || is_null($userPermintaan->cabang_id)) {
            return true;
        }

        return $userPenawaran->cabang_id !== $userPermintaan->cabang_id;
    }

    // skor_matching sekarang murni informatif (indikator kualitas kecocokan volume +
    // tipe), BUKAN penentu approval otomatis - semua kandidat tetap wajib dipilih
    // manual oleh Pusat/Admin sebelum jadi Project.
    private function hitungSkor(PenawaranRincianSize $rincianPenawaran, PermintaanRincianSize $rincianPermintaan): float
    {
        $skor = 70; // base score: komoditi + size sudah exact match

        $kecil = min($rincianPenawaran->kuantiti, $rincianPermintaan->kuantiti);
        $besar = max($rincianPenawaran->kuantiti, $rincianPermintaan->kuantiti);
        $rasioKuantiti = $besar > 0 ? ($kecil / $besar) : 0;
        $skor += $rasioKuantiti * 30;

        return round(min($skor, 100), 2);
    }

    private function simpanJikaBelumAda(
        Penawaran $penawaran,
        PenawaranRincianSize $rincianPenawaran,
        Permintaan $permintaan,
        PermintaanRincianSize $rincianPermintaan
    ): ?MatchSuggestion {
        $sudahAda = MatchSuggestion::where('penawaran_rincian_id', $rincianPenawaran->id)
            ->where('permintaan_rincian_id', $rincianPermintaan->id)
            ->exists();

        if ($sudahAda) {
            return null;
        }

        return MatchSuggestion::create([
            'penawaran_id' => $penawaran->id,
            'permintaan_id' => $permintaan->id,
            'penawaran_rincian_id' => $rincianPenawaran->id,
            'permintaan_rincian_id' => $rincianPermintaan->id,
            'skor_matching' => $this->hitungSkor($rincianPenawaran, $rincianPermintaan),
            'status' => 'terbuka',
        ]);
    }
}
