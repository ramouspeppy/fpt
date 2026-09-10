<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomoditiFotoController extends Controller
{
    // Halaman kelola foto - satu komoditi cuma punya satu foto (bukan galeri).
    // Beda dari form Tambah/Usulan Komoditi (yang cuma text field), halaman ini
    // khusus untuk upload/ganti/hapus foto, komoditi-nya sudah pasti ada dulu.
    public function index(Komoditi $komoditi)
    {
        $komoditi->load('kategoriKomoditi');

        return view('komoditi.foto.index', compact('komoditi'));
    }

    // Upload atau ganti foto. FilePond di sini dipakai sebagai input file biasa
    // (allowprocess: false) - jadi file-nya ikut terkirim lewat form <form> normal,
    // bukan lewat endpoint AJAX terpisah. addMedia otomatis mengganti foto lama
    // karena collection 'foto' didaftarkan sebagai singleFile().
    public function store(Request $request, Komoditi $komoditi)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $komoditi
            ->addMediaFromRequest('foto')
            ->toMediaCollection('foto');

        activity('komoditi_foto')
            ->performedOn($komoditi)
            ->causedBy(Auth::user())
            ->log('mengubah foto komoditi');

        return redirect()->route('komoditi.foto.index', $komoditi)->with('status', 'Foto komoditi berhasil disimpan.');
    }

    // Hapus foto yang ada (kembali tanpa foto).
    public function destroy(Komoditi $komoditi)
    {
        $komoditi->clearMediaCollection('foto');

        activity('komoditi_foto')
            ->performedOn($komoditi)
            ->causedBy(Auth::user())
            ->log('menghapus foto komoditi');

        return redirect()->route('komoditi.foto.index', $komoditi)->with('status', 'Foto komoditi dihapus.');
    }
}
