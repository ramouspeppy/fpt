<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\Penawaran;
use App\Models\PenawaranDetailEkspor;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenawaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Penawaran::with(['user.cabang', 'rincianGrade', 'komoditi'])->latest();

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

        $penawaran = $query->paginate(15)->withQueryString();

        return view('penawaran.index', compact('penawaran'));
    }

    public function create()
    {
        $komoditiList = Komoditi::disetujui()->orderBy('kategori')->orderBy('nama')->get()->groupBy('kategori');

        return view('penawaran.create', compact('komoditiList'));
    }

    public function store(Request $request, MatchingService $matchingService)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal,Ekspor & Lokal'],
            'jenis_penawaran' => ['required', 'in:Produksi Sendiri,Trading'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'kondisi_ikan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
            // rincian grade - minimal 1 baris
            'grade' => ['required', 'array', 'min:1'],
            'grade.*' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'kuantiti.*' => ['required', 'numeric', 'min:0'],
            // rincian biaya HPP / margin - WAJIB minimal 1 baris (label bebas, menyesuaikan jenis_penawaran)
            'biaya_label' => ['required', 'array', 'min:1'],
            'biaya_label.*' => ['required', 'string', 'max:255'],
            'biaya_jumlah' => ['required', 'array', 'min:1'],
            'biaya_jumlah.*' => ['required', 'numeric', 'min:0'],
        ]);

        $penawaran = Penawaran::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'jenis_penawaran' => $validated['jenis_penawaran'],
            'komoditi_id' => $validated['komoditi_id'],
            'kondisi_ikan' => $validated['kondisi_ikan'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'tersedia',
        ]);

        $this->simpanRincianGrade($penawaran, $validated);
        $this->simpanBiayaHpp($penawaran, $validated);

        if ($penawaran->mengandungEkspor()) {
            PenawaranDetailEkspor::create([
                'penawaran_id' => $penawaran->id,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                'negara_tujuan' => $validated['negara_tujuan'] ?? null,
            ]);
        }

        // langsung cari kecocokan begitu penawaran baru tersimpan
        $matchingService->generateForPenawaran($penawaran->fresh('rincianGrade'));

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil ditambahkan.');
    }

    public function show(Penawaran $penawaran)
    {
        $penawaran->load(['user.cabang', 'detailEkspor', 'rincianGrade', 'komoditi', 'biayaHpp']);

        return view('penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $penawaran->load(['detailEkspor', 'rincianGrade', 'komoditi', 'biayaHpp']);
        $komoditiList = Komoditi::disetujui()->orderBy('kategori')->orderBy('nama')->get()->groupBy('kategori');

        return view('penawaran.edit', compact('penawaran', 'komoditiList'));
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal,Ekspor & Lokal'],
            'jenis_penawaran' => ['required', 'in:Produksi Sendiri,Trading'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'kondisi_ikan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
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
            'biaya_label' => ['required', 'array', 'min:1'],
            'biaya_label.*' => ['required', 'string', 'max:255'],
            'biaya_jumlah' => ['required', 'array', 'min:1'],
            'biaya_jumlah.*' => ['required', 'numeric', 'min:0'],
        ]);

        $penawaran->update([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'jenis_penawaran' => $validated['jenis_penawaran'],
            'komoditi_id' => $validated['komoditi_id'],
            'kondisi_ikan' => $validated['kondisi_ikan'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => $validated['status'],
        ]);

        // ganti semua rincian grade & biaya HPP lama dengan yang baru (paling sederhana untuk versi ini)
        $penawaran->rincianGrade()->delete();
        $this->simpanRincianGrade($penawaran, $validated);

        $penawaran->biayaHpp()->delete();
        $this->simpanBiayaHpp($penawaran, $validated);

        if ($penawaran->mengandungEkspor()) {
            $penawaran->detailEkspor()->updateOrCreate(
                ['penawaran_id' => $penawaran->id],
                [
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

    // Tombol aksi cepat (mis. "Tandai Sedang Diproses", "Tandai Selesai") tanpa perlu buka form Edit penuh.
    // Status posting sepenuhnya keputusan manual pemilik/Admin, tidak pernah diubah otomatis oleh sistem.
    public function updateStatus(Request $request, Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);

        $validated = $request->validate([
            'status' => ['required', 'in:tersedia,matched,selesai,ditutup'],
        ]);

        $penawaran->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Status penawaran berhasil diperbarui.');
    }

    private function simpanRincianGrade(Penawaran $penawaran, array $validated): void
    {
        foreach ($validated['grade'] as $i => $grade) {
            $penawaran->rincianGrade()->create([
                'ukuran_grade' => $grade,
                'harga' => $validated['harga'][$i],
                'kuantiti' => $validated['kuantiti'][$i],
            ]);
        }
    }

    // Biaya HPP (proses, packing, listrik, tenaga kerja, dll) - WAJIB minimal 1 baris,
    // berlaku sama untuk semua grade dalam penawaran ini (bukan per grade).
    private function simpanBiayaHpp(Penawaran $penawaran, array $validated): void
    {
        foreach ($validated['biaya_label'] as $i => $label) {
            $penawaran->biayaHpp()->create([
                'label' => $label,
                'jumlah' => $validated['biaya_jumlah'][$i],
            ]);
        }
    }

    private function authorizePemilikAtauAdmin(Penawaran $penawaran): void
    {
        $user = Auth::user();

        abort_unless($user->id === $penawaran->user_id || $user->hasRole('Admin'), 403);
    }
}
