@props([
    'name',
    'context',
    'existingMedia' => null,
    'uploadRoute',
    'deleteTempRoute',
    'deleteExistingUrlBase' => null,
    'acceptedFiles' => null,
    'maxFiles' => null,
    'maxFilesizeMb' => 5,
    'previewAsImage' => true,
])

@php
    $existingMedia = $existingMedia ?? collect();

    // Item "resmi" (sudah tersimpan sebagai media) - hapusnya langsung ke server.
    $daftarResmi = $existingMedia->map(fn ($m) => [
        'id' => $m->id,
        'url' => $previewAsImage ? $m->getUrl('thumb') : $m->getUrl(),
        'file_name' => $m->file_name,
        'size' => $m->size,
        'is_temp' => false,
    ]);

    // BARU: item yang sudah ke-upload ke folder temp tapi form gagal submit karena
    // validasi field LAIN - supaya tidak "hilang" dan tidak perlu upload ulang dari nol.
    // old($name) balikin array nama file temp yang masih tersimpan di session flash.
    $daftarTemp = collect(old($name, []))->map(fn ($tempName) => [
        'id' => null,
        'url' => route('mediaTemp.preview', ['context' => $context, 'name' => $tempName]),
        'file_name' => $tempName,
        'size' => null,
        'is_temp' => true,
        'temp_name' => $tempName,
    ]);

    $existingJson = $daftarResmi->concat($daftarTemp)->values()->toJson();
@endphp

<div class="dropzone dropzone-gallery"
    data-upload-url="{{ $uploadRoute }}"
    data-delete-temp-url="{{ $deleteTempRoute }}"
    @if ($deleteExistingUrlBase) data-delete-existing-url-base="{{ $deleteExistingUrlBase }}" @endif
    data-context="{{ $context }}"
    data-field-name="{{ $name }}"
    @if ($acceptedFiles) data-accepted-files="{{ $acceptedFiles }}" @endif
    @if ($maxFiles) data-max-files="{{ $maxFiles }}" @endif
    data-max-filesize-mb="{{ $maxFilesizeMb }}"
    data-existing='{{ $existingJson }}'
    @if ($previewAsImage) data-preview-as-image="1" @endif
></div>
