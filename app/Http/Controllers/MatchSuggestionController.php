<?php

namespace App\Http\Controllers;

use App\Models\MatchSuggestion;
use App\Models\Penawaran;
use App\Models\Permintaan;
use App\Services\MatchingService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MatchSuggestionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MatchSuggestion::with([
            'penawaran.user.cabang',
            'permintaan.user.cabang',
            'penawaranRincian.komoditiSize',
            'permintaanRincian.komoditiSize',
        ])
            // Kandidat yang statusnya 'terbuka' tapi Penawaran/Permintaan-nya sudah
            // terkunci (karena kepilih di pasangan lain) otomatis disembunyikan -
            // sudah tidak relevan lagi untuk dipilih.
            ->where(function ($q) {
                $q->where('status', 'dipilih')
                    ->orWhere(function ($qq) {
                        $qq->where('status', 'terbuka')
                            ->whereHas('penawaran', fn ($p) => $p->where('status', 'tersedia'))
                            ->whereHas('permintaan', fn ($p) => $p->where('status', 'tersedia'));
                    });
            })
            ->latest();

        if ($user->hasRole('Cabang')) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('penawaran', fn ($qq) => $qq->where('user_id', $user->id))
                  ->orWhereHas('permintaan', fn ($qq) => $qq->where('user_id', $user->id));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter khusus per Penawaran/Permintaan - supaya bisa dicek langsung
        // "posting ini ada berapa kandidat yang bisa dijadikan project".
        if ($request->filled('penawaran_id')) {
            $query->where('penawaran_id', $request->penawaran_id);
        }

        if ($request->filled('permintaan_id')) {
            $query->where('permintaan_id', $request->permintaan_id);
        }

        // Kelompokkan per pasangan Penawaran-Permintaan supaya tidak tampil berulang
        // kalau ada beberapa size yang sama-sama cocok - representatif diambil yang
        // skor_matching paling tinggi, ditandai jumlah size yang cocok di pasangan itu.
        $semuaMatch = $query->get();

        $kelompok = $semuaMatch
            ->groupBy(fn ($m) => $m->penawaran_id . '-' . $m->permintaan_id)
            ->map(function ($grup) {
                $representatif = $grup->sortByDesc('skor_matching')->first();
                $representatif->jumlah_size_cocok = $grup->count();

                return $representatif;
            })
            ->values();

        $halaman = (int) $request->get('page', 1);
        $perHalaman = 15;

        $matches = new LengthAwarePaginator(
            $kelompok->forPage($halaman, $perHalaman)->values(),
            $kelompok->count(),
            $perHalaman,
            $halaman,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Opsi dropdown filter - dibatasi hanya Penawaran/Permintaan yang benar-benar
        // punya kandidat match (bukan seluruh data), dan untuk Cabang cukup miliknya sendiri.
        $opsiPenawaran = Penawaran::whereHas('matchSuggestions')
            ->when($user->hasRole('Cabang'), fn ($q) => $q->where('user_id', $user->id))
            ->orderBy('judul')
            ->get(['id', 'judul']);

        $opsiPermintaan = Permintaan::whereHas('matchSuggestions')
            ->when($user->hasRole('Cabang'), fn ($q) => $q->where('user_id', $user->id))
            ->orderBy('judul')
            ->get(['id', 'judul']);

        return view('match.index', compact('matches', 'opsiPenawaran', 'opsiPermintaan'));
    }

    public function jalankan(MatchingService $service)
    {
        $jumlah = $service->runAll();

        return redirect()->route('match.index')
            ->with('status', "Pencarian selesai. {$jumlah} kandidat kecocokan baru ditemukan.");
    }

    // Halaman preview - bandingkan detail lengkap Penawaran vs Permintaan
    // sebelum Pusat/Admin memutuskan memilihnya jadi Project. Menampilkan SEMUA
    // size yang cocok di pasangan ini sekaligus (bukan cuma 1 size per halaman).
    public function show(MatchSuggestion $match)
    {
        $user = Auth::user();

        if ($user->hasRole('Cabang')) {
            $terlibat = $match->penawaran->user_id === $user->id || $match->permintaan->user_id === $user->id;
            abort_unless($terlibat, 403);
        }

        $match->load([
            'penawaran.user.cabang',
            'penawaran.komoditi',
            'penawaran.rincianSize.komoditiSize',
            'penawaran.biayaHpp',
            'penawaran.detailEkspor',
            'permintaan.user.cabang',
            'permintaan.komoditi',
            'permintaan.rincianSize.komoditiSize',
            'permintaan.detailEkspor',
        ]);

        // Semua kandidat match lain untuk pasangan Penawaran-Permintaan yang sama
        // (kalau ada beberapa size yang sama-sama cocok), supaya ditampilkan sekaligus.
        $semuaKandidat = MatchSuggestion::where('penawaran_id', $match->penawaran_id)
            ->where('permintaan_id', $match->permintaan_id)
            ->with(['penawaranRincian.komoditiSize', 'permintaanRincian.komoditiSize'])
            ->get();

        $penawaranRincianIdCocok = $semuaKandidat->pluck('penawaran_rincian_id');
        $permintaanRincianIdCocok = $semuaKandidat->pluck('permintaan_rincian_id');

        return view('match.show', compact('match', 'semuaKandidat', 'penawaranRincianIdCocok', 'permintaanRincianIdCocok'));
    }

    // Pusat/Admin memilih kandidat ini sebagai pemenang -> jadi Project.
    // Berlaku untuk SEMUA match (Lokal maupun Ekspor), tidak ada beda jalur lagi.
    public function pilih(MatchSuggestion $match, ProjectService $projectService)
    {
        $this->authorizePusatAtauAdmin();

        try {
            $project = $projectService->pilihMatch($match, Auth::user());
        } catch (ValidationException $e) {
            return redirect()->route('match.show', $match)->withErrors($e->errors());
        }

        return redirect()->route('project.show', $project)
            ->with('status', 'Match dipilih sebagai pemenang. Project baru dibuat, Penawaran & Permintaan terkait terkunci.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
