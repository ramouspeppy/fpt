@extends('layouts.app')

@section('title', 'Edit Cabang')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Cabang</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cabang.update', $cabang) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Cabang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" class="form-control @error('nama_cabang') is-invalid @enderror">
                        @error('nama_cabang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $cabang->lokasi) }}" class="form-control @error('lokasi') is-invalid @enderror">
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Region (opsional)</label>
                        <input type="text" name="region" value="{{ old('region', $cabang->region) }}" class="form-control">
                    </div>
                    <div class="text-right">
                        <a href="{{ route('cabang.index') }}" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
