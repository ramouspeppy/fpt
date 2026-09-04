<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\KomoditiTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomoditiTagController extends Controller
{
    // Halaman ini bisa diakses SEMUA role yang login (bukan cuma Admin/Pusat) -
    // dibuka dari form Tambah Penawaran/Permintaan saat memilih komoditi.
    public function index(Komoditi $komoditi)
    {
        $komoditi->load(['tags.penambah', 'kategoriKomoditi']);

        return view('komoditi.tag.index', compact('komoditi'));
    }

    // Siapapun yang login boleh nambah tag - tanpa approval, karena ini murni info
    // alias/nama daerah, bukan komitmen harga/kuantiti. Duplikat (case-insensitive)
    // dicegah lewat constraint unique di database.
    public function store(Request $request, Komoditi $komoditi)
    {
        $validated = $request->validate([
            'nama_tag' => ['required', 'string', 'max:255'],
        ]);

        $sudahAda = $komoditi->tags()->whereRaw('LOWER(nama_tag) = ?', [strtolower($validated['nama_tag'])])->exists();

        if ($sudahAda) {
            return redirect()->back()->withErrors(['nama_tag' => 'Nama daerah ini sudah pernah ditambahkan untuk komoditi ini.']);
        }

        KomoditiTag::create([
            'komoditi_id' => $komoditi->id,
            'nama_tag' => $validated['nama_tag'],
            'ditambahkan_oleh' => Auth::id(),
        ]);

        return redirect()->back()->with('status', 'Nama daerah berhasil ditambahkan.');
    }

    // Semua orang yang login boleh hapus tag yang salah/tidak relevan.
    public function destroy(Komoditi $komoditi, KomoditiTag $tag)
    {
        abort_unless($tag->komoditi_id === $komoditi->id, 404);

        $tag->delete();

        return redirect()->back()->with('status', 'Tag dihapus.');
    }
}
