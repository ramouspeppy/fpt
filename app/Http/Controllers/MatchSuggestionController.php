<?php

namespace App\Http\Controllers;

use App\Models\MatchSuggestion;
use App\Services\MatchingService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
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
            ->with('status', "Pencarian selesai. {$jumlah} kandidat kecocokan baru ditemukan.");
    }

    // Pusat/Admin memilih kandidat ini sebagai pemenang -> jadi Project.
    // Berlaku untuk SEMUA match (Lokal maupun Ekspor), tidak ada beda jalur lagi.
    public function pilih(MatchSuggestion $match, ProjectService $projectService)
    {
        $this->authorizePusatAtauAdmin();

        try {
            $project = $projectService->pilihMatch($match, Auth::user());
        } catch (ValidationException $e) {
            return redirect()->route('match.index')->withErrors($e->errors());
        }

        return redirect()->route('project.show', $project)
            ->with('status', 'Match dipilih sebagai pemenang. Project baru dibuat, Penawaran & Permintaan terkait terkunci.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
