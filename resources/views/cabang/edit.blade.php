@extends('layouts.app')

@section('title', 'Edit Cabang')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('cabang.update', $cabang) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label required">Nama Cabang</label>
                <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" class="form-control @error('nama_cabang') is-invalid @enderror">
                @error('nama_cabang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label required">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $cabang->lokasi) }}" class="form-control @error('lokasi') is-invalid @enderror">
                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Region (opsional)</label>
                <input type="text" name="region" value="{{ old('region', $cabang->region) }}" class="form-control">
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('cabang.index') }}" class="btn btn-link">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
