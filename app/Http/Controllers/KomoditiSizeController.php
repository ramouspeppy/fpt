<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\KomoditiSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomoditiSizeController extends Controller
{
    // Daftar size milik 1 komoditi - khusus Admin/Pusat, bisa lihat semua status + approve/tolak usulan
    public function index(Komoditi $komoditi)
    {
        $this->authorizePusatAtauAdmin();

        $sizes = $komoditi->sizes()->with(['pengusul', 'approver'])->urutTampil()->get();

        return view('komoditi.size.index', compact('komoditi', 'sizes'));
    }

    // Admin/Pusat input langsung -> otomatis disetujui
    public function store(Request $request, Komoditi $komoditi)
    {
        $this->authorizePusatAtauAdmin();

        $validated = $request->validate([
            'nama_size' => ['required', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer'],
        ]);

        $komoditi->sizes()->create([
            'nama_size' => $validated['nama_size'],
            'urutan' => $validated['urutan'] ?? null,
            'status' => 'disetujui',
            'diusulkan_oleh' => Auth::id(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.size.index', $komoditi)->with('status', 'Size berhasil ditambahkan.');
    }

    // Form usulan size baru - bisa diakses semua role (termasuk Cabang)
    public function usulkan(Komoditi $komoditi)
    {
        return view('komoditi.size.usulkan', compact('komoditi'));
    }

    // Usulan dari Cabang -> status menunggu_approval, belum bisa dipakai di form
    // Penawaran/Permintaan sampai di-approve Admin/Pusat.
    public function simpanUsulan(Request $request, Komoditi $komoditi)
    {
        $validated = $request->validate([
            'nama_size' => ['required', 'string', 'max:255'],
        ]);

        $komoditi->sizes()->create([
            'nama_size' => $validated['nama_size'],
            'status' => 'menunggu_approval',
            'diusulkan_oleh' => Auth::id(),
            'approved_by' => null,
        ]);

        return redirect()->route('komoditi.size.usulkan', $komoditi)
            ->with('status', 'Usulan size berhasil dikirim, menunggu persetujuan Admin/Pusat.');
    }

    public function approve(Komoditi $komoditi, KomoditiSize $size)
    {
        $this->authorizePusatAtauAdmin();

        abort_unless($size->status === 'menunggu_approval', 400, 'Size ini tidak dalam status menunggu approval.');

        $size->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.size.index', $komoditi)->with('status', 'Size disetujui, sudah bisa dipakai di form.');
    }

    public function tolak(Komoditi $komoditi, KomoditiSize $size)
    {
        $this->authorizePusatAtauAdmin();

        $size->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('komoditi.size.index', $komoditi)->with('status', 'Usulan size ditolak.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
