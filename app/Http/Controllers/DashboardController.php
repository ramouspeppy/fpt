<?php

namespace App\Http\Controllers;

use App\Models\MatchSuggestion;
use App\Models\Penawaran;
use App\Models\Permintaan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenawaranTersedia = Penawaran::where('status', 'tersedia')->count();
        $totalPermintaanTersedia = Permintaan::where('status', 'tersedia')->count();
        $matchMenungguReview = MatchSuggestion::where('status', 'menunggu_review')->count();

        $penawaranTerbaru = Penawaran::with(['user.cabang'])->latest()->take(5)->get();
        $permintaanTerbaru = Permintaan::with(['user.cabang'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPenawaranTersedia',
            'totalPermintaanTersedia',
            'matchMenungguReview',
            'penawaranTerbaru',
            'permintaanTerbaru'
        ));
    }
}
