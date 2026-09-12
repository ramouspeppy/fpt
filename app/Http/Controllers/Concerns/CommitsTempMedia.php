<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

// Dipakai bareng oleh PenawaranController & PermintaanController - keduanya punya
// pola galeri foto (bebas jumlah) + video (maks 2) yang identik.
trait CommitsTempMedia
{
    // Pindahkan file dari folder temp (hasil upload Dropzone sebelum form disubmit)
    // jadi media resmi milik $model. File temp yang sudah tidak ada (mis. dihapus
    // manual atau race condition) dilewati saja, tidak dianggap error fatal.
    protected function commitTempMedia($model, string $collection, string $context, array $tempNames): void
    {
        foreach ($tempNames as $name) {
            $name = basename((string) $name); // cegah path traversal
            $relativePath = 'temp-uploads/' . Auth::id() . '/' . $context . '/' . $name;

            if (! Storage::disk('local')->exists($relativePath)) {
                continue;
            }

            // addMedia() dari path (bukan UploadedFile) secara default MEMINDAHKAN file
            // sumbernya (bukan cuma copy) - jadi folder temp otomatis bersih sendiri
            // setelah berhasil di-commit, tanpa perlu hapus manual.
            $model->addMedia(Storage::disk('local')->path($relativePath))
                ->toMediaCollection($collection);
        }
    }

    // Video dibatasi maksimal $maksimal per posting (default 2) - dihitung dari total
    // video yang SUDAH ada (kalau edit) ditambah video baru yang mau di-commit.
    protected function validasiBatasVideo(int $jumlahSudahAda, array $tempNamesBaru, string $field = 'video_gallery', int $maksimal = 2): void
    {
        $totalSetelahnya = $jumlahSudahAda + count($tempNamesBaru);

        if ($totalSetelahnya > $maksimal) {
            throw ValidationException::withMessages([
                $field => "Maksimal {$maksimal} video per posting (saat ini sudah ada {$jumlahSudahAda}).",
            ]);
        }
    }
}
