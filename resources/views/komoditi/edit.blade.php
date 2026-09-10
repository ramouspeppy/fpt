@extends('layouts.app')

@section('title', 'Edit Komoditi - ' . $komoditi->nama)

@section('content')
<div class="row">
    <div class="col-md-7 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Edit Komoditi</h4>
            </div>
            <div class="card-body">
                @if ($komoditi->status === 'menunggu_approval')
                    <div class="alert alert-warning">
                        Usulan ini masih menunggu approval Admin/Pusat. Anda bisa membetulkan
                        nama/kategori sebelum di-review.
                    </div>
                @endif

                <form method="POST" action="{{ route('komoditi.update', $komoditi) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Nama Komoditi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $komoditi->nama) }}"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control select2" data-placeholder="-- Pilih Kategori --">
                            <option value=""></option>
                            @foreach ($kategoriList as $kat)
                                <option value="{{ $kat->id }}" @selected(old('kategori_id', $komoditi->kategori_id) == $kat->id)>{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                        @if (auth()->user()->hasAnyRole(['Pusat', 'Admin']))
                            <small class="form-text text-muted">
                                Kategori belum ada di daftar? <a href="{{ route('kategoriKomoditi.index') }}">Tambah dulu di sini</a>.
                            </small>
                        @else
                            <small class="form-text text-muted">
                                Kategori belum ada yang sesuai? Kosongkan saja, atau hubungi Admin/Pusat untuk menambahkan kategori baru.
                            </small>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('komoditi.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
