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
        $query = Penawaran::with(['user.cabang', 'rincianSize.komoditiSize', 'komoditi'])->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhereHas('komoditi', fn ($qq) => $qq->where('nama', 'like', '%' . $request->cari . '%'))
                  ->orWhereHas('komoditi.tags', fn ($qq) => $qq->where('nama_tag', 'like', '%' . $request->cari . '%'));
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
        $komoditiList = $this->komoditiListUntukForm();
        $sizesByKomoditi = $this->sizesByKomoditiJson();

        return view('penawaran.create', compact('komoditiList', 'sizesByKomoditi'));
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
            // rincian size - minimal 1 baris. komoditi_size_id WAJIB milik komoditi yang dipilih & sudah disetujui.
            'komoditi_size_id' => ['required', 'array', 'min:1'],
            'komoditi_size_id.*' => ['required', 'exists:komoditi_size,id'],
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

        $this->pastikanSizeMilikKomoditi($validated['komoditi_id'], $validated['komoditi_size_id']);

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

        $this->simpanRincianSize($penawaran, $validated);
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
        $matchingService->generateForPenawaran($penawaran->fresh('rincianSize'));

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil ditambahkan.');
    }

    public function show(Penawaran $penawaran)
    {
        $penawaran->load(['user.cabang', 'detailEkspor', 'rincianSize.komoditiSize', 'komoditi', 'biayaHpp', 'project']);

        return view('penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);
        $this->tolakJikaTerkunci($penawaran);

        $penawaran->load(['detailEkspor', 'rincianSize.komoditiSize', 'komoditi', 'biayaHpp']);
        $komoditiList = $this->komoditiListUntukForm();
        $sizesByKomoditi = $this->sizesByKomoditiJson();

        return view('penawaran.edit', compact('penawaran', 'komoditiList', 'sizesByKomoditi'));
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);
        $this->tolakJikaTerkunci($penawaran);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal,Ekspor & Lokal'],
            'jenis_penawaran' => ['required', 'in:Produksi Sendiri,Trading'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'kondisi_ikan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,selesai,tutup'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'kontinuitas_suplai' => ['nullable', 'string', 'max:255'],
            'negara_tujuan' => ['nullable', 'string', 'max:255'],
            'komoditi_size_id' => ['required', 'array', 'min:1'],
            'komoditi_size_id.*' => ['required', 'exists:komoditi_size,id'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'kuantiti.*' => ['required', 'numeric', 'min:0'],
            'biaya_label' => ['required', 'array', 'min:1'],
            'biaya_label.*' => ['required', 'string', 'max:255'],
            'biaya_jumlah' => ['required', 'array', 'min:1'],
            'biaya_jumlah.*' => ['required', 'numeric', 'min:0'],
        ]);

        $this->pastikanSizeMilikKomoditi($validated['komoditi_id'], $validated['komoditi_size_id']);

        $penawaran->update([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'jenis_penawaran' => $validated['jenis_penawaran'],
            'komoditi_id' => $validated['komoditi_id'],
            'kondisi_ikan' => $validated['kondisi_ikan'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => $validated['status'],
        ]);

        // ganti semua rincian size & biaya HPP lama dengan yang baru (paling sederhana untuk versi ini)
        $penawaran->rincianSize()->delete();
        $this->simpanRincianSize($penawaran, $validated);

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
        $this->tolakJikaTerkunci($penawaran);

        $penawaran->delete();

        return redirect()->route('penawaran.index')->with('status', 'Penawaran berhasil dihapus.');
    }

    // Tombol aksi cepat (mis. "Tandai Selesai", "Tutup") tanpa perlu buka form Edit penuh.
    // Status posting sepenuhnya keputusan manual pemilik/Admin - TAPI kalau sudah 'sedang_diproses'
    // (sudah jadi Project), perubahan status di sini diblokir; harus lewat halaman Project.
    public function updateStatus(Request $request, Penawaran $penawaran)
    {
        $this->authorizePemilikAtauAdmin($penawaran);
        $this->tolakJikaTerkunci($penawaran);

        $validated = $request->validate([
            'status' => ['required', 'in:tersedia,selesai,tutup'],
        ]);

        $penawaran->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Status penawaran berhasil diperbarui.');
    }

    private function simpanRincianSize(Penawaran $penawaran, array $validated): void
    {
        foreach ($validated['komoditi_size_id'] as $i => $komoditiSizeId) {
            $penawaran->rincianSize()->create([
                'komoditi_size_id' => $komoditiSizeId,
                'harga' => $validated['harga'][$i],
                'kuantiti' => $validated['kuantiti'][$i],
            ]);
        }
    }

    // Biaya HPP (proses, packing, listrik, tenaga kerja, dll) - WAJIB minimal 1 baris,
    // berlaku sama untuk semua size dalam penawaran ini (bukan per size).
    private function simpanBiayaHpp(Penawaran $penawaran, array $validated): void
    {
        foreach ($validated['biaya_label'] as $i => $label) {
            $penawaran->biayaHpp()->create([
                'label' => $label,
                'jumlah' => $validated['biaya_jumlah'][$i],
            ]);
        }
    }

    // Cegah salah pilih size dari komoditi lain (dropdown size harusnya sudah difilter
    // per komoditi via JS, ini validasi jaga-jaga di sisi server).
    private function pastikanSizeMilikKomoditi(int $komoditiId, array $komoditiSizeIds): void
    {
        $jumlahValid = \App\Models\KomoditiSize::where('komoditi_id', $komoditiId)
            ->whereIn('id', $komoditiSizeIds)
            ->count();

        abort_unless($jumlahValid === count(array_unique($komoditiSizeIds)), 422, 'Ada size yang tidak sesuai dengan komoditi yang dipilih.');
    }

    // Peta komoditi_id => daftar size disetujui miliknya, dipakai JS di form untuk
    // mengisi dropdown size secara dinamis sesuai komoditi yang dipilih (cascading).
    private function sizesByKomoditiJson(): string
    {
        $map = \App\Models\KomoditiSize::disetujui()->urutTampil()->get()
            ->groupBy('komoditi_id')
            ->map(fn ($group) => $group->map(fn ($s) => ['id' => $s->id, 'nama_size' => $s->nama_size])->values());

        return $map->toJson();
    }

    // Daftar komoditi utk dropdown form - dikelompokkan per Kategori (via relasi, bukan
    // teks bebas lagi), tiap komoditi disertai daftar tag/nama daerahnya supaya bisa
    // ikut ke-search di select2 (tag ditampilkan di belakang nama resmi, dalam kurung).
    private function komoditiListUntukForm()
    {
        return Komoditi::disetujui()
            ->with(['kategoriKomoditi', 'tags'])
            ->get()
            ->sortBy([
                fn ($k) => $k->kategoriKomoditi->nama ?? 'zzz',
                fn ($k) => $k->nama,
            ])
            ->groupBy(fn ($k) => $k->kategoriKomoditi->nama ?? 'Lainnya');
    }

    private function tolakJikaTerkunci(Penawaran $penawaran): void
    {
        abort_if($penawaran->sudah_terkunci, 403, 'Penawaran ini sudah terkunci karena menjadi bagian dari Project, tidak bisa diubah lagi.');
    }

    private function authorizePemilikAtauAdmin(Penawaran $penawaran): void
    {
        $user = Auth::user();

        abort_unless($user->id === $penawaran->user_id || $user->hasRole('Admin'), 403);
    }
}
