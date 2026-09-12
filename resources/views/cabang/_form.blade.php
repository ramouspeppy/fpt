@php
    $isEdit = isset($cabang);
@endphp

<form method="POST" action="{{ $isEdit ? route('cabang.update', $cabang) : route('cabang.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Nama Cabang <span class="text-danger">*</span></label>
        <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $isEdit ? $cabang->nama_cabang : '') }}"
            class="form-control @error('nama_cabang') is-invalid @enderror">
        @error('nama_cabang') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Lokasi <span class="text-danger">*</span></label>
        <input type="text" name="lokasi" value="{{ old('lokasi', $isEdit ? $cabang->lokasi : '') }}"
            class="form-control @error('lokasi') is-invalid @enderror">
        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Region (opsional)</label>
        <input type="text" name="region" value="{{ old('region', $isEdit ? $cabang->region : '') }}" class="form-control">
    </div>

    <div class="text-right">
        <a href="{{ route('cabang.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
        @if ($isEdit)
            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Simpan Perubahan</button>
        @else
            <button type="submit" class="btn btn-info"><i class="fas fa-plus"></i> Simpan</button>
        @endif
    </div>
</form>
