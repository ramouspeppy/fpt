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
        $query = MatchSuggestion::with([
            'penawaran.user.cabang',
            'permintaan.user.cabang',
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $matches = $query->paginate(15)->withQueryString();

        return view('match.index', compact('matches'));
    }

    // Tombol "Cari Kecocokan Ulang" - scan semua penawaran/permintaan yang masih tersedia
    public function jalankan(MatchingService $service)
    {
        $jumlah = $service->runAll();

        return redirect()->route('match.index')
            ->with('status', "Pencarian selesai. {$jumlah} kecocokan baru ditemukan.");
    }

    // Hanya Pusat/Admin yang boleh approve, dan hanya untuk match tipe ekspor (status menunggu_review)
    public function approve(MatchSuggestion $match)
    {
        $this->authorizePusatAtauAdmin();

        abort_unless($match->status === 'menunggu_review', 400, 'Match ini tidak dalam status menunggu review.');

        $match->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        // begitu disetujui, tandai penawaran & permintaan sebagai matched
        // (penawaran tipe "Ekspor & Lokal" tetap "tersedia" jika masih ada porsi lain yang mungkin match)
        if (! $match->penawaran->mengandungEkspor() || $match->penawaran->tipe !== 'Ekspor & Lokal') {
            $match->penawaran->update(['status' => 'matched']);
        }
        $match->permintaan->update(['status' => 'matched']);

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
