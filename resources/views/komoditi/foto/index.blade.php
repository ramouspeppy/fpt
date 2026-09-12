@extends('layouts.app')

@section('title', 'Foto - ' . $komoditi->nama)

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4>{{ $komoditi->nama }}</h4>
            </div>
            <div class="card-body text-center">
                <div class="text-muted small mb-3">
                    {{ $komoditi->kategoriKomoditi->nama ?? '-' }} &middot;
                    Foto ini membantu Cabang lain mengenali komoditi saat melihat daftar Penawaran/Permintaan.
                    Satu komoditi hanya bisa punya satu foto - upload baru akan menggantikan yang lama.
                </div>

                @if ($komoditi->fotoUtama())
                    <img src="{{ $komoditi->fotoUtama()->getUrl('thumb') }}" alt="Foto {{ $komoditi->nama }}"
                        class="img-fluid rounded border mb-3" style="max-height: 260px;">
                    <form method="POST" action="{{ route('komoditi.foto.destroy', $komoditi) }}"
                        onsubmit="return confirm('Hapus foto komoditi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus Foto</button>
                    </form>
                @else
                    <div class="alert alert-info mb-0">Belum ada foto untuk komoditi ini.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4>{{ $komoditi->fotoUtama() ? 'Ganti Foto' : 'Upload Foto' }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('komoditi.foto.store', $komoditi) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>File Foto <span class="text-danger">*</span></label>
                        <input type="file" name="foto" class="filepond @error('foto') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                        <small class="form-text text-muted">Format JPG/PNG/WEBP, maksimal 5 MB.</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-plus"></i> Simpan Foto
                    </button>
                    <a href="{{ route('komoditi.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
