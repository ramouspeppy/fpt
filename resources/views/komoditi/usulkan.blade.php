@extends('layouts.app')

@section('title', 'Usulkan Komoditi Baru')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Usulkan Komoditi Baru</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Tidak menemukan komoditi yang Anda cari di form Penawaran/Permintaan? Usulkan di sini.
                    Usulan Anda akan direview dulu oleh Admin/Pusat sebelum bisa dipakai.
                </div>
                <form method="POST" action="{{ route('komoditi.simpanUsulan') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Komoditi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="mis. Ikan Kuwe">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Kategori (opsional)</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control" placeholder="mis. Ikan, Udang, Kepiting, Cumi & Gurita">
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Usulan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
