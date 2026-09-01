@extends('layouts.app')

@section('title', 'Usulkan Size Baru')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Usulkan Size Baru &mdash; {{ $komoditi->nama }}</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Tidak menemukan size yang Anda cari di form Penawaran/Permintaan untuk komoditi
                    <strong>{{ $komoditi->nama }}</strong>? Usulkan di sini. Usulan Anda akan direview
                    dulu oleh Admin/Pusat sebelum bisa dipakai.
                </div>
                <form method="POST" action="{{ route('komoditi.size.simpanUsulan', $komoditi) }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Size <span class="text-danger">*</span></label>
                        <input type="text" name="nama_size" value="{{ old('nama_size') }}" class="form-control @error('nama_size') is-invalid @enderror" placeholder="mis. 2000UP">
                        @error('nama_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Usulan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
