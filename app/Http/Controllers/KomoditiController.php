<?php

namespace App\Http\Controllers;

use App\Models\KategoriKomoditi;
use App\Models\Komoditi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KomoditiController extends Controller
{
    // Halaman kelola master data - bisa dilihat SEMUA role yang login, tapi aksi kelola
    // (tambah/approve/tolak) tetap dibatasi Admin/Pusat lewat method masing-masing di bawah.
    public function index(Request $request)
    {
        $user = Auth::user();
        $bolehKelola = $user->hasAnyRole(['Pusat', 'Admin']);

        $query = Komoditi::with(['pengusul', 'approver', 'kategoriKomoditi', 'tags', 'media'])
            ->join('kategori_komoditi', 'komoditi.kategori_id', '=', 'kategori_komoditi.id')
            ->orderBy('kategori_komoditi.nama')
            ->orderBy('komoditi.nama')
            ->select('komoditi.*');

        if ($bolehKelola) {
            // Admin/Pusat boleh filter & lihat semua status (termasuk menunggu approval/ditolak)
            if ($request->filled('status')) {
                $query->where('komoditi.status', $request->status);
            }
        } else {
            // Cabang/role lain cukup lihat data yang sudah valid dipakai
            $query->where('komoditi.status', 'disetujui');
        }

        $komoditi = $query->paginate(20)->withQueryString();
        $kategoriList = $bolehKelola ? KategoriKomoditi::orderBy('nama')->get() : collect();

        return view('komoditi.index', compact('komoditi', 'kategoriList', 'bolehKelola'));
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

    // Form usulan - bisa diakses SEMUA role (termasuk Cabang). Sekarang tampil 2 kolom:
    // riwayat usulan milik user ini sendiri (supaya tidak lupa & tidak usul berulang-ulang),
    // dan form usulan baru dengan bantuan select2 tags supaya nama yang mirip/sudah ada
    // kelihatan duluan sebelum submit.
    public function usulkan()
    {
        $kategoriList = KategoriKomoditi::orderBy('nama')->get();

        $riwayatSaya = Komoditi::where('diusulkan_oleh', Auth::id())
            ->with('kategoriKomoditi')
            ->latest()
            ->get();

        // Semua nama komoditi yang SUDAH ADA (apapun statusnya - disetujui, menunggu approval,
        // maupun ditolak) - jadi suggestion di select2 tags, supaya user sadar sebelum submit
        // kalau nama itu sudah pernah diusulkan/terdaftar oleh siapa saja.
        $semuaNamaKomoditi = Komoditi::orderBy('nama')->get(['nama', 'status']);

        return view('komoditi.usulkan', compact('kategoriList', 'riwayatSaya', 'semuaNamaKomoditi'));
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
        ], [
            'nama.unique' => 'Nama ini sudah pernah diusulkan/terdaftar sebelumnya (lihat daftar di sebelah kiri) - coba nama yang lebih spesifik.',
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

    // BARU: edit nama & kategori. Sengaja dibatasi cuma untuk 2 kondisi:
    // - Admin/Pusat, untuk komoditi yang statusnya sudah disetujui (data master yang dipakai luas).
    // - Cabang, tapi HANYA untuk usulan MILIK SENDIRI yang masih menunggu_approval (belum
    //   dipakai siapa pun, jadi aman diubah sebelum di-review Admin/Pusat).
    // Komoditi berstatus 'ditolak' sengaja tidak bisa diedit - alurnya usul ulang dengan nama baru.
    private function authorizeEdit(Komoditi $komoditi): void
    {
        $user = Auth::user();

        if ($komoditi->status === 'disetujui') {
            abort_unless($user->hasAnyRole(['Pusat', 'Admin']), 403);
            return;
        }

        if ($komoditi->status === 'menunggu_approval') {
            abort_unless($komoditi->diusulkan_oleh === $user->id, 403);
            return;
        }

        abort(403, 'Komoditi yang sudah ditolak tidak bisa diedit - silakan usulkan ulang dengan nama yang baru.');
    }

    public function edit(Komoditi $komoditi)
    {
        $this->authorizeEdit($komoditi);

        $kategoriList = KategoriKomoditi::orderBy('nama')->get();

        return view('komoditi.edit', compact('komoditi', 'kategoriList'));
    }

    public function update(Request $request, Komoditi $komoditi)
    {
        $this->authorizeEdit($komoditi);

        // Cabang yang edit usulan sendiri tidak boleh bikin kategori baru sendiri,
        // sama seperti waktu usul pertama kali - cukup pilih yang sudah ada / kosong.
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('komoditi', 'nama')->ignore($komoditi->id)],
            'kategori_id' => ['nullable', 'exists:kategori_komoditi,id'],
        ]);

        $komoditi->update([
            'nama' => $validated['nama'],
            'kategori_id' => $validated['kategori_id'] ?? null,
        ]);

        activity('komoditi')
            ->performedOn($komoditi)
            ->causedBy(Auth::user())
            ->withProperties(['nama' => $komoditi->nama, 'kategori_id' => $komoditi->kategori_id])
            ->log('mengubah data komoditi');

        return redirect()->route('komoditi.index')->with('status', 'Komoditi berhasil diperbarui.');
    }
}
