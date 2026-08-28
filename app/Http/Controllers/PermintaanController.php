<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permintaan::with(['user.cabang', 'rincianGrade', 'komoditi'])->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhereHas('komoditi', fn ($qq) => $qq->where('nama', 'like', '%' . $request->cari . '%'));
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permintaan = $query->paginate(15)->withQueryString();

        return view('permintaan.index', compact('permintaan'));
    }

    public function create()
    {
        $komoditiList = Komoditi::disetujui()->orderBy('kategori')->orderBy('nama')->get()->groupBy('kategori');

        return view('permintaan.create', compact('komoditiList'));
    }

    public function store(Request $request, MatchingService $matchingService)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'keterangan' => ['nullable', 'string'],
            'prioritas_warna' => ['nullable', 'in:merah,kuning,hijau'],
            'prioritas_tag' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
            'grade' => ['required', 'array', 'min:1'],
            'grade.*' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'kuantiti.*' => ['required', 'numeric', 'min:0'],
        ]);

        $permintaan = Permintaan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'komoditi_id' => $validated['komoditi_id'],
            'keterangan' => $validated['keterangan'] ?? null,
            'prioritas_warna' => $validated['prioritas_warna'] ?? null,
            'prioritas_tag' => $validated['prioritas_tag'] ?? null,
            'status' => 'tersedia',
        ]);

        $this->simpanRincianGrade($permintaan, $validated);

        if ($permintaan->isEkspor()) {
            PermintaanDetailEkspor::create([
                'permintaan_id' => $permintaan->id,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                'negara_tujuan' => $validated['negara_tujuan'] ?? null,
            ]);
        }

        $matchingService->generateForPermintaan($permintaan->fresh('rincianGrade'));

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil ditambahkan.');
    }

    public function show(Permintaan $permintaan)
    {
        $permintaan->load(['user.cabang', 'detailEkspor', 'rincianGrade', 'komoditi']);

        return view('permintaan.show', compact('permintaan'));
    }

    public function edit(Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $permintaan->load(['detailEkspor', 'rincianGrade', 'komoditi']);
        $komoditiList = Komoditi::disetujui()->orderBy('kategori')->orderBy('nama')->get()->groupBy('kategori');

        return view('permintaan.edit', compact('permintaan', 'komoditiList'));
    }

    public function update(Request $request, Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'keterangan' => ['nullable', 'string'],
            'prioritas_warna' => ['nullable', 'in:merah,kuning,hijau'],
            'prioritas_tag' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:tersedia,matched,selesai,ditutup'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
            'grade' => ['required', 'array', 'min:1'],
            'grade.*' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'kuantiti.*' => ['required', 'numeric', 'min:0'],
        ]);

        $permintaan->update([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'komoditi_id' => $validated['komoditi_id'],
            'keterangan' => $validated['keterangan'] ?? null,
            'prioritas_warna' => $validated['prioritas_warna'] ?? null,
            'prioritas_tag' => $validated['prioritas_tag'] ?? null,
            'status' => $validated['status'],
        ]);

        $permintaan->rincianGrade()->delete();
        $this->simpanRincianGrade($permintaan, $validated);

        if ($permintaan->isEkspor()) {
            $permintaan->detailEkspor()->updateOrCreate(
                ['permintaan_id' => $permintaan->id],
                [
                    'sertifikasi' => $validated['sertifikasi'] ?? null,
                    'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                    'negara_tujuan' => $validated['negara_tujuan'] ?? null,
                ]
            );
        } else {
            $permintaan->detailEkspor()->delete();
        }

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil diperbarui.');
    }

    public function destroy(Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $permintaan->delete();

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil dihapus.');
    }

    // Tombol aksi cepat, sama pola-nya dengan PenawaranController@updateStatus.
    public function updateStatus(Request $request, Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $validated = $request->validate([
            'status' => ['required', 'in:tersedia,matched,selesai,ditutup'],
        ]);

        $permintaan->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Status permintaan berhasil diperbarui.');
    }

    private function simpanRincianGrade(Permintaan $permintaan, array $validated): void
    {
        foreach ($validated['grade'] as $i => $grade) {
            $permintaan->rincianGrade()->create([
                'ukuran_grade' => $grade,
                'harga' => $validated['harga'][$i],
                'kuantiti' => $validated['kuantiti'][$i],
            ]);
        }
    }

    private function authorizePemilikAtauAdmin(Permintaan $permintaan): void
    {
        $user = Auth::user();

        abort_unless($user->id === $permintaan->user_id || $user->hasRole('Admin'), 403);
    }
}
