<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\KomoditiSize;
use App\Models\Permintaan;
use App\Models\PermintaanDetailEkspor;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permintaan::with(['user.cabang', 'rincianSize.komoditiSize', 'komoditi'])->latest();

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

        $permintaan = $query->paginate(15)->withQueryString();

        return view('permintaan.index', compact('permintaan'));
    }

    public function create()
    {
        $komoditiList = $this->komoditiListUntukForm();
        $sizesByKomoditi = $this->sizesByKomoditiJson();

        return view('permintaan.create', compact('komoditiList', 'sizesByKomoditi'));
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
            'komoditi_size_id' => ['required', 'array', 'min:1'],
            'komoditi_size_id.*' => ['required', 'exists:komoditi_size,id'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'kuantiti' => ['required', 'array', 'min:1'],
            'kuantiti.*' => ['required', 'numeric', 'min:0'],
        ]);

        $this->pastikanSizeMilikKomoditi($validated['komoditi_id'], $validated['komoditi_size_id']);

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

        $this->simpanRincianSize($permintaan, $validated);

        if ($permintaan->isEkspor()) {
            PermintaanDetailEkspor::create([
                'permintaan_id' => $permintaan->id,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'kontinuitas_suplai' => $validated['kontinuitas_suplai'] ?? null,
                'negara_tujuan' => $validated['negara_tujuan'] ?? null,
            ]);
        }

        $matchingService->generateForPermintaan($permintaan->fresh('rincianSize'));

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil ditambahkan.');
    }

    public function show(Permintaan $permintaan)
    {
        $permintaan->load(['user.cabang', 'detailEkspor', 'rincianSize.komoditiSize', 'komoditi', 'project']);

        return view('permintaan.show', compact('permintaan'));
    }

    public function edit(Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);
        $this->tolakJikaTerkunci($permintaan);

        $permintaan->load(['detailEkspor', 'rincianSize.komoditiSize', 'komoditi']);
        $komoditiList = $this->komoditiListUntukForm();
        $sizesByKomoditi = $this->sizesByKomoditiJson();

        return view('permintaan.edit', compact('permintaan', 'komoditiList', 'sizesByKomoditi'));
    }

    public function update(Request $request, Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);
        $this->tolakJikaTerkunci($permintaan);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:Ekspor,Lokal'],
            'komoditi_id' => ['required', 'exists:komoditi,id'],
            'keterangan' => ['nullable', 'string'],
            'prioritas_warna' => ['nullable', 'in:merah,kuning,hijau'],
            'prioritas_tag' => ['nullable', 'string', 'max:255'],
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
        ]);

        $this->pastikanSizeMilikKomoditi($validated['komoditi_id'], $validated['komoditi_size_id']);

        $permintaan->update([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'komoditi_id' => $validated['komoditi_id'],
            'keterangan' => $validated['keterangan'] ?? null,
            'prioritas_warna' => $validated['prioritas_warna'] ?? null,
            'prioritas_tag' => $validated['prioritas_tag'] ?? null,
            'status' => $validated['status'],
        ]);

        $permintaan->rincianSize()->delete();
        $this->simpanRincianSize($permintaan, $validated);

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
        $this->tolakJikaTerkunci($permintaan);

        $permintaan->delete();

        return redirect()->route('permintaan.index')->with('status', 'Permintaan berhasil dihapus.');
    }

    // Tombol aksi cepat, sama pola-nya dengan PenawaranController@updateStatus.
    public function updateStatus(Request $request, Permintaan $permintaan)
    {
        $this->authorizePemilikAtauAdmin($permintaan);
        $this->tolakJikaTerkunci($permintaan);

        $validated = $request->validate([
            'status' => ['required', 'in:tersedia,selesai,tutup'],
        ]);

        $permintaan->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Status permintaan berhasil diperbarui.');
    }

    private function simpanRincianSize(Permintaan $permintaan, array $validated): void
    {
        foreach ($validated['komoditi_size_id'] as $i => $komoditiSizeId) {
            $permintaan->rincianSize()->create([
                'komoditi_size_id' => $komoditiSizeId,
                'harga' => $validated['harga'][$i],
                'kuantiti' => $validated['kuantiti'][$i],
            ]);
        }
    }

    private function pastikanSizeMilikKomoditi(int $komoditiId, array $komoditiSizeIds): void
    {
        $jumlahValid = KomoditiSize::where('komoditi_id', $komoditiId)
            ->whereIn('id', $komoditiSizeIds)
            ->count();

        abort_unless($jumlahValid === count(array_unique($komoditiSizeIds)), 422, 'Ada size yang tidak sesuai dengan komoditi yang dipilih.');
    }

    private function sizesByKomoditiJson(): string
    {
        $map = KomoditiSize::disetujui()->urutTampil()->get()
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

    private function tolakJikaTerkunci(Permintaan $permintaan): void
    {
        abort_if($permintaan->sudah_terkunci, 403, 'Permintaan ini sudah terkunci karena menjadi bagian dari Project, tidak bisa diubah lagi.');
    }

    private function authorizePemilikAtauAdmin(Permintaan $permintaan): void
    {
        $user = Auth::user();

        abort_unless($user->id === $permintaan->user_id || $user->hasRole('Admin'), 403);
    }
}
