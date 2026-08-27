<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\PenawaranDetailEkspor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\MatchingService;


class PenawaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Penawaran::with(['user.cabang'])->latest();

        // pencarian sederhana
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

        $penawaran = $query->paginate(15)->withQueryString();

        return view('penawaran.index', compact('penawaran'));
    }

    public function create()
    {
        return view('penawaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal,Ekspor & Lokal'],
            'jenis_ikan' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:0'],
            'harga' => ['nullable', 'numeric', 'min:0'],
            'kondisi_ikan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            // field ekspor, wajib diisi jika tipe mengandung Ekspor (divalidasi manual di bawah)
            'grading' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
        ]);

        $penawaran = Penawaran::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'jenis_ikan' => $validated['jenis_ikan'],
            'volume' => $validated['volume'],
            'harga' => $validated['harga'] ?? null,
            'kondisi_ikan' => $validated['kondisi_ikan'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'tersedia',
        ]);

        if ($penawaran->mengandungEkspor()) {
            PenawaranDetailEkspor::create([
                'penawaran_id' => $penawaran->id,
                'grading' => $validated['grading'] ?? null,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                'negara_tujuan' => $validated['negara_tujuan'] ?? null,
            ]);
        }

        app(MatchingService::class)->generateForPenawaran($penawaran);

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil ditambahkan.');
    }

    public function show(Penawaran $penawaran)
    {
        $penawaran->load(['user.cabang', 'detailEkspor']);

        return view('penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $penawaran->load('detailEkspor');

        return view('penawaran.edit', compact('penawaran'));
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal,Ekspor & Lokal'],
            'jenis_ikan' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:0'],
            'harga' => ['nullable', 'numeric', 'min:0'],
            'kondisi_ikan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,matched,selesai,ditutup'],
            'grading' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
        ]);

        $penawaran->update($validated);

        if ($penawaran->mengandungEkspor()) {
            $penawaran->detailEkspor()->updateOrCreate(
                ['penawaran_id' => $penawaran->id],
                [
                    'grading' => $validated['grading'] ?? null,
                    'sertifikasi' => $validated['sertifikasi'] ?? null,
                    'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                    'negara_tujuan' => $validated['negara_tujuan'] ?? null,
                ]
            );
        } else {
            $penawaran->detailEkspor()->delete();
        }

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil diperbarui.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $penawaran->delete();

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil dihapus.');
    }

    // Hanya pemilik posting atau Admin yang boleh ubah/hapus (sesuai kesepakatan: status diubah manual oleh pemilik atau admin)
    private function authorizePemilikAtauAdmin(Penawaran $penawaran): void
    {
        $user = Auth::user();

        abort_unless($user->id === $penawaran->user_id || $user->hasRole('Admin'), 403);
    }
}
