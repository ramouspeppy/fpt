@php
    $isEdit = isset($komoditi);
@endphp

@if (!$isEdit)
    <div class="text-muted small mb-3">
        Input langsung oleh Admin/Pusat otomatis disetujui, tidak perlu approval.
        Foto boleh dikosongkan dulu, bisa ditambahkan belakangan lewat halaman Edit.
    </div>
@elseif ($komoditi->status === 'menunggu_approval')
    <div class="alert alert-warning">
        Usulan ini masih menunggu approval Admin/Pusat. Anda bisa membetulkan
        nama/kategori sebelum di-review.
    </div>
@endif

<form method="POST" action="{{ $isEdit ? route('komoditi.update', $komoditi) : route('komoditi.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <div class="form-group">
        <label>Nama Komoditi <span class="text-danger">*</span></label>
        <input type="text" name="nama" value="{{ old('nama', $isEdit ? $komoditi->nama : '') }}"
            class="form-control @error('nama') is-invalid @enderror">
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control select2" data-placeholder="-- Pilih Kategori --">
            <option value=""></option>
            @foreach ($kategoriList as $kat)
                <option value="{{ $kat->id }}" @selected(old('kategori_id', $isEdit ? $komoditi->kategori_id : null) == $kat->id)>{{ $kat->nama }}</option>
            @endforeach
        </select>
        @if (auth()->user()->hasAnyRole(['Pusat', 'Admin']))
            <small class="form-text text-muted">
                Kategori belum ada di daftar? <a href="{{ route('kategoriKomoditi.index') }}">Tambah dulu di sini</a>.
            </small>
        @elseif ($isEdit)
            <small class="form-text text-muted">
                Kategori belum ada yang sesuai? Kosongkan saja, atau hubungi Admin/Pusat untuk menambahkan kategori baru.
            </small>
        @endif
    </div>

    <div class="form-group mb-0">
        <label>Foto</label>
        <div class="d-flex justify-content-center">
            <input type="file" name="foto" class="filepond-preview @error('foto') is-invalid @enderror"
                accept="image/jpeg,image/png,image/webp" data-aspect-ratio="1:1" data-preview-height="170"
                @if ($isEdit && $komoditi->fotoUtama()) data-existing-url="{{ $komoditi->fotoUtama()->getUrl('thumb') }}" @endif>
        </div>
        <small class="form-text text-muted text-center d-block">
            Format JPG/PNG/WEBP, maksimal 5 MB.
            @if (!$isEdit)
                Opsional.
            @elseif ($komoditi->fotoUtama())
                Ganti foto di atas kalau mau diperbarui, atau biarkan saja kalau tidak berubah.
            @endif
        </small>
        @error('foto')
            <div class="invalid-feedback d-block text-center">{{ $message }}</div>
        @enderror
    </div>

    <div class="mt-3">
        @if ($isEdit)
            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Simpan Perubahan</button>
        @else
            <button type="submit" class="btn btn-info"><i class="fas fa-plus"></i> Tambah & Setujui</button>
        @endif
        <a href="{{ route('komoditi.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</form>
