<?php

namespace App\Http\Controllers;

use App\Models\KategoriKomoditi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKomoditiController extends Controller
{
    // Khusus Admin/Pusat - kategori sifatnya taksonomi besar, jarang berubah,
    // jadi tidak perlu alur approval seperti Komoditi/Size.
    public function index()
    {
        $this->authorizePusatAtauAdmin();

        $kategoriList = KategoriKomoditi::withCount('komoditi')->orderBy('nama')->get();

        return view('kategori-komoditi.index', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $this->authorizePusatAtauAdmin();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_komoditi,nama'],
        ]);

        KategoriKomoditi::create($validated);

        return redirect()->route('kategoriKomoditi.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(KategoriKomoditi $kategoriKomoditi)
    {
        $this->authorizePusatAtauAdmin();

        abort_if($kategoriKomoditi->komoditi()->exists(), 400, 'Kategori ini masih dipakai oleh komoditi, tidak bisa dihapus.');

        $kategoriKomoditi->delete();

        return redirect()->route('kategoriKomoditi.index')->with('status', 'Kategori berhasil dihapus.');
    }

    private function authorizePusatAtauAdmin(): void
    {
        abort_unless(Auth::user()->hasAnyRole(['Pusat', 'Admin']), 403);
    }
}
