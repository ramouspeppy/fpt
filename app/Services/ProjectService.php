<?php

namespace App\Services;

use App\Models\MatchSuggestion;
use App\Models\Project;
use App\Models\ProjectCatatan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectService
{
    /**
     * Pusat/Admin memilih 1 pasangan Penawaran-Permintaan sebagai pemenang (diwakili
     * oleh salah satu kandidat match-nya).
     * Efeknya:
     * - SEMUA kandidat match untuk pasangan Penawaran-Permintaan yang sama (bisa lebih
     *   dari 1 kalau ada beberapa size yang sama-sama cocok) -> status 'dipilih'.
     *   Bukan cuma yang diklik, karena penguncian tetap di level seluruh posting,
     *   bukan per size - jadi semua kandidat size lain untuk pasangan ini ikut final.
     * - Project baru dibuat, status awal 'sedang_diproses'
     * - SELURUH Penawaran & Permintaan yang terlibat langsung terkunci (status
     *   'sedang_diproses'), termasuk size lain di Penawaran itu yang belum laku.
     *   Kandidat match untuk Permintaan/Penawaran lain yang tidak terpilih TIDAK diubah
     *   statusnya - otomatis tersaring dari list karena postingan terkaitnya sudah terkunci.
     */
    public function pilihMatch(MatchSuggestion $match, User $pemilih): Project
    {
        if ($match->status !== 'terbuka') {
            throw ValidationException::withMessages([
                'match' => 'Kandidat match ini sudah tidak berstatus terbuka.',
            ]);
        }

        return DB::transaction(function () use ($match, $pemilih) {
            MatchSuggestion::where('penawaran_id', $match->penawaran_id)
                ->where('permintaan_id', $match->permintaan_id)
                ->where('status', 'terbuka')
                ->update(['status' => 'dipilih']);

            $project = Project::create([
                'match_suggestion_id' => $match->id,
                'penawaran_id' => $match->penawaran_id,
                'permintaan_id' => $match->permintaan_id,
                'status' => 'sedang_diproses',
                'dipilih_oleh' => $pemilih->id,
            ]);

            $match->penawaran()->update(['status' => 'sedang_diproses']);
            $match->permintaan()->update(['status' => 'sedang_diproses']);

            return $project;
        });
    }

    /**
     * Ubah status project. Kalau statusnya jadi 'tutup', catatan alasan WAJIB diisi.
     */
    public function updateStatus(Project $project, string $status, User $user, ?string $catatan = null): Project
    {
        if ($status === 'tutup' && empty(trim((string) $catatan))) {
            throw ValidationException::withMessages([
                'catatan' => 'Alasan penutupan project wajib diisi.',
            ]);
        }

        return DB::transaction(function () use ($project, $status, $user, $catatan) {
            $project->update(['status' => $status]);

            if (! empty(trim((string) $catatan))) {
                $this->tambahCatatan($project, $user, $catatan);
            }

            return $project->fresh();
        });
    }

    /**
     * Tambah catatan/progress ke project. Catatan bersifat permanen (tidak bisa
     * diedit/dihapus) - boleh ditulis kedua cabang terlibat maupun Pusat/Admin.
     */
    public function tambahCatatan(Project $project, User $user, string $isiCatatan): ProjectCatatan
    {
        return ProjectCatatan::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'isi_catatan' => $isiCatatan,
        ]);
    }
}
