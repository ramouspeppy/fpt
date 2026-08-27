<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\MatchingService;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permintaan::with(['user.cabang'])->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                    ->orWhere('jenis_ikan', 'like', '%' . $request->cari . '%');
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
        return view('permintaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal'],
            'jenis_ikan' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:0'],
            'harga_maksimal' => ['nullable', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'prioritas_warna' => ['nullable', 'in:merah,kuning,hijau'],
            'prioritas_tag' => ['nullable', 'string', 'max:255'],
            'grading' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
        ]);

        $permintaan = Permintaan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'jenis_ikan' => $validated['jenis_ikan'],
            'volume' => $validated['volume'],
            'harga_maksimal' => $validated['harga_maksimal'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'prioritas_warna' => $validated['prioritas_warna'] ?? null,
            'prioritas_tag' => $validated['prioritas_tag'] ?? null,
            'status' => 'tersedia',
        ]);

        if ($permintaan->isEkspor()) {
            PermintaanDetailEkspor::create([
                'permintaan_id' => $permintaan->id,
                'grading' => $validated['grading'] ?? null,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                'negara_tujuan' => $validated['negara_tujuan'] ?? null,
            ]);
        }

        app(MatchingService::class)->generateForPermintaan($permintaan);

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil ditambahkan.');
    }

    public function show(Permintaan $permintaan)
    {
        $permintaan->load(['user.cabang', 'detailEkspor']);

        return view('permintaan.show', compact('permintaan'));
    }

    public function edit(Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $permintaan->load('detailEkspor');

        return view('permintaan.edit', compact('permintaan'));
    }

    public function update(Request $request, Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal'],
            'jenis_ikan' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:0'],
            'harga_maksimal' => ['nullable', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'prioritas_warna' => ['nullable', 'in:merah,kuning,hijau'],
            'prioritas_tag' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:tersedia,matched,selesai,ditutup'],
            'grading' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
        ]);

        $permintaan->update($validated);

        if ($permintaan->isEkspor()) {
            $permintaan->detailEkspor()->updateOrCreate(
                ['permintaan_id' => $permintaan->id],
                [
                    'grading' => $validated['grading'] ?? null,
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

    private function authorizePemilikAtauAdmin(Permintaan $permintaan): void
    {
        $user = Auth::user();

        abort_unless($user->id === $permintaan->user_id || $user->hasRole('Admin'), 403);
    }
}
