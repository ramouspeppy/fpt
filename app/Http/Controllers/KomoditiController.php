<?php

namespace App\Http\Controllers;

use App\Models\KategoriKomoditi;
use App\Models\Komoditi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomoditiController extends Controller
{
    // Halaman kelola master data - khusus Admin/Pusat, bisa lihat semua status + approve/tolak usulan
    public function index(Request $request)
    {
        $this->authorizePusatAtauAdmin();

        $query = Komoditi::with(['pengusul', 'approver', 'kategoriKomoditi', 'tags'])
            ->join('kategori_komoditi', 'komoditi.kategori_id', '=', 'kategori_komoditi.id')
            ->orderBy('kategori_komoditi.nama')
            ->orderBy('komoditi.nama')
            ->select('komoditi.*');

        if ($request->filled('status')) {
            $query->where('komoditi.status', $request->status);
        }

        $komoditi = $query->paginate(20)->withQueryString();
        $kategoriList = KategoriKomoditi::orderBy('nama')->get();

        return view('komoditi.index', compact('komoditi', 'kategoriList'));
    }

    // Admin/Pusat input langsung -> otomatis disetujui, tidak perlu approval siapa pun
    public function store(Request $request)
    {
        $this->authorizePusatAtauAdmin();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:komoditi,nama'],
            'kategori_id' => ['nullable', 'exists:kategori_komoditi,id'],
        ]);

        Komoditi::create([
            'nama' => $validated['nama'],
            'kategori_id' => $validated['kategori_id'] ?? null,
            'status' => 'disetujui',
            'diusulkan_oleh' => Auth::id(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.index')->with('status', 'Komoditi berhasil ditambahkan.');
    }

    // Form usulan - bisa diakses SEMUA role (termasuk Cabang)
    public function usulkan()
    {
        $kategoriList = KategoriKomoditi::orderBy('nama')->get();

        return view('komoditi.usulkan', compact('kategoriList'));
    }

    // Usulan dari Cabang -> status menunggu_approval, baru bisa dipakai setelah di-approve.
    // Cabang cuma bisa PILIH kategori yang sudah ada (tidak bisa bikin kategori baru sendiri) -
    // kalau tidak ada yang cocok, biarkan kosong dan jelaskan di nama/catatan, nanti
    // Admin/Pusat yang menambahkan kategori barunya dulu sebelum approve.
    public function simpanUsulan(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:komoditi,nama'],
            'kategori_id' => ['nullable', 'exists:kategori_komoditi,id'],
        ]);

        Komoditi::create([
            'nama' => $validated['nama'],
            'kategori_id' => $validated['kategori_id'] ?? null,
            'status' => 'menunggu_approval',
            'diusulkan_oleh' => Auth::id(),
            'approved_by' => null,
        ]);

        return redirect()->route('komoditi.usulkan')
            ->with('status', 'Usulan komoditi berhasil dikirim, menunggu persetujuan Admin/Pusat.');
    }

    public function approve(Komoditi $komoditi)
    {
        $this->authorizePusatAtauAdmin();

        abort_unless($komoditi->status === 'menunggu_approval', 400, 'Komoditi ini tidak dalam status menunggu approval.');

        $komoditi->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.index')->with('status', 'Komoditi disetujui, sudah bisa dipakai di form Penawaran/Permintaan.');
    }

    public function tolak(Komoditi $komoditi)
    {
        $this->authorizePusatAtauAdmin();

        $komoditi->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.index')->with('status', 'Usulan komoditi ditolak.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
