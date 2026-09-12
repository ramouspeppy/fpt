<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaTempController extends Controller
{
    // Batas ukuran & mime per context - dicek manual di sini (bukan Request::validate biasa)
    // supaya pesan errornya bisa langsung dikembalikan ke Dropzone dalam format yang dia paham.
    private const ATURAN = [
        'foto' => [
            'mimes' => ['image/jpeg', 'image/png', 'image/webp'],
            'max_kb' => 5120, // 5 MB
        ],
        // 'video' TIDAK ada di sini lagi - video sekarang upload langsung lewat form
        // (FilePond biasa), tidak lewat temp-upload seperti foto. Endpoint ini sekarang
        // cuma dipakai untuk context "foto".
    ];

    // Folder temp per-user, supaya tidak tabrakan antar user yang bersamaan lagi isi form.
    // Disimpan di disk 'local' (storage/app/private) - TIDAK publik, karena file di sini
    // cuma transit sebelum di-commit ke MediaLibrary saat form disubmit.
    private function folderTemp(string $context): string
    {
        return 'temp-uploads/' . Auth::id() . '/' . $context;
    }

    // Dipanggil Dropzone setiap satu file selesai di-drop (auto upload ke sini dulu,
    // BUKAN langsung ke media milik Penawaran/Permintaan - itu baru terjadi saat form
    // utama disubmit, lihat commitTempMedia() di Penawaran/PermintaanController).
    public function upload(Request $request)
    {
        $context = $request->input('context');
        abort_unless(isset(self::ATURAN[$context]), 422, 'Context upload tidak dikenali.');

        $aturan = self::ATURAN[$context];

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimetypes:' . implode(',', $aturan['mimes']),
                'max:' . $aturan['max_kb'],
            ],
        ]);

        $file = $request->file('file');
        $namaUnik = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs($this->folderTemp($context), $namaUnik, 'local');

        return response()->json([
            'name' => $namaUnik,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    // Dipanggil saat user klik hapus (x) di Dropzone SEBELUM form disubmit -
    // file yang baru saja di-upload ke temp dibuang lagi, belum pernah jadi media resmi.
    public function delete(Request $request)
    {
        $context = $request->input('context');
        $name = basename((string) $request->input('name')); // basename() cegah path traversal

        abort_unless(isset(self::ATURAN[$context]), 422, 'Context upload tidak dikenali.');

        Storage::disk('local')->delete($this->folderTemp($context) . '/' . $name);

        return response()->noContent();
    }

    // BARU: tampilkan file yang masih di folder temp - dipakai untuk menampilkan ulang
    // preview foto yang sudah sempat di-upload, waktu form disubmit ulang setelah validasi
    // gagal di field LAIN (mis. Judul kosong). Tanpa ini, foto yang sudah ke-upload akan
    // "hilang" dari tampilan padahal filenya masih ada di server, dan harus upload dari nol.
    // Dibatasi cuma boleh lihat folder temp milik diri sendiri (Auth::id()).
    public function preview(string $context, string $name)
    {
        abort_unless(isset(self::ATURAN[$context]), 404);

        $path = $this->folderTemp($context) . '/' . basename($name);

        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }
}
