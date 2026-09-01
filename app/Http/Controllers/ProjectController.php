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

        $query = Project::with([
            'penawaran.user.cabang',
            'permintaan.user.cabang',
            'pemilih',
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

        $projects = $query->paginate(15)->withQueryString();

        return view('project.index', compact('projects'));
    }

    public function show(Project $project)
    {
        abort_unless($project->bolehDiaksesOleh(Auth::user()), 403);

        $project->load([
            'penawaran.user.cabang',
            'penawaran.rincianSize.komoditiSize',
            'permintaan.user.cabang',
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
