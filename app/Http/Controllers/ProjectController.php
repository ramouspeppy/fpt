<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    // Cabang hanya lihat project yang melibatkan posting miliknya sendiri.
    // Pusat/Admin lihat semua project.
    public function index(Request $request)
    {
        $user = Auth::user();

        $baseQuery = Project::query();

        if ($user->hasRole('Cabang')) {
            $baseQuery->where(function ($q) use ($user) {
                $q->whereHas('penawaran', fn ($qq) => $qq->where('user_id', $user->id))
                  ->orWhereHas('permintaan', fn ($qq) => $qq->where('user_id', $user->id));
            });
        }

        // Statistik ringkas per status - selalu dihitung dari scope penuh (tidak ikut
        // filter status yang aktif), supaya kartu statistik bisa dipakai sebagai
        // pintasan filter juga (klik kartu -> otomatis filter ke status itu).
        $statistik = [
            'total' => (clone $baseQuery)->count(),
            'sedang_diproses' => (clone $baseQuery)->where('status', 'sedang_diproses')->count(),
            'selesai' => (clone $baseQuery)->where('status', 'selesai')->count(),
            'tutup' => (clone $baseQuery)->where('status', 'tutup')->count(),
        ];

        $query = (clone $baseQuery)->with([
            'penawaran.user.cabang',
            'permintaan.user.cabang',
            'pemilih',
            'catatan' => fn ($q) => $q->latest()->limit(1),
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate(12)->withQueryString();

        return view('project.index', compact('projects', 'statistik'));
    }

    public function show(Project $project)
    {
        abort_unless($project->bolehDiaksesOleh(Auth::user()), 403);

        $project->load([
            'penawaran.user.cabang',
            'penawaran.komoditi',
            'penawaran.detailEkspor',
            'penawaran.rincianSize.komoditiSize',
            'permintaan.user.cabang',
            'permintaan.komoditi',
            'permintaan.detailEkspor',
            'permintaan.rincianSize.komoditiSize',
            'pemilih',
            'catatan.user',
        ]);

        return view('project.show', compact('project'));
    }

    // Status: sedang_diproses -> selesai / tutup. Kalau 'tutup', catatan alasan wajib.
    public function updateStatus(Request $request, Project $project, ProjectService $service)
    {
        abort_unless($project->bolehDiaksesOleh(Auth::user()), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:sedang_diproses,selesai,tutup'],
            'catatan' => ['nullable', 'string'],
        ]);

        try {
            $service->updateStatus($project, $validated['status'], Auth::user(), $validated['catatan'] ?? null);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }

        return redirect()->route('project.show', $project)->with('status', 'Status project berhasil diperbarui.');
    }

    // Tambah catatan progress - boleh kedua cabang terlibat maupun Pusat/Admin.
    // Catatan permanen, tidak ada endpoint edit/hapus.
    public function storeCatatan(Request $request, Project $project, ProjectService $service)
    {
        abort_unless($project->bolehDiaksesOleh(Auth::user()), 403);

        $validated = $request->validate([
            'isi_catatan' => ['required', 'string'],
        ]);

        $service->tambahCatatan($project, Auth::user(), $validated['isi_catatan']);

        return redirect()->route('project.show', $project)->with('status', 'Catatan berhasil ditambahkan.');
    }
}
