<?php

namespace App\Http\Controllers;

use App\Models\MatchSuggestion;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchSuggestionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MatchSuggestion::with([
            'penawaran.user.cabang',
            'permintaan.user.cabang',
            'penawaranRincian',
            'permintaanRincian',
        ])->latest();

        if ($user->hasRole('Cabang')) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('penawaran', fn ($qq) => $qq->where('user_id', $user->id))
                  ->orWhereHas('permintaan', fn ($qq) => $qq->where('user_id', $user->id));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $matches = $query->paginate(15)->withQueryString();

        return view('match.index', compact('matches'));
    }

    public function jalankan(MatchingService $service)
    {
        $jumlah = $service->runAll();

        return redirect()->route('match.index')
            ->with('status', "Pencarian selesai. {$jumlah} kecocokan baru ditemukan.");
    }

    public function approve(MatchSuggestion $match)
    {
        $this->authorizePusatAtauAdmin();

        abort_unless($match->status === 'menunggu_review', 400, 'Match ini tidak dalam status menunggu review.');

        $match->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        // CATATAN: status Penawaran/Permintaan SENGAJA TIDAK diubah otomatis di sini.
        // Approval Pusat hanya berarti "match ini valid untuk diteruskan ke cabang",
        // bukan berarti transaksi sudah pasti terjadi. Status posting (tersedia/matched/
        // selesai/ditutup) sepenuhnya jadi keputusan manual pemilik posting atau Admin,
        // lewat tombol aksi cepat di halaman detail Penawaran/Permintaan.

        return redirect()->route('match.index')->with('status', 'Match disetujui, notifikasi diteruskan ke kedua cabang.');
    }

    public function tolak(Request $request, MatchSuggestion $match)
    {
        $this->authorizePusatAtauAdmin();

        $match->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
            'catatan' => $request->input('catatan'),
        ]);

        return redirect()->route('match.index')->with('status', 'Match ditolak.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
