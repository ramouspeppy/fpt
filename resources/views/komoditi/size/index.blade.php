@extends('layouts.app')

@section('title', 'Size - ' . $komoditi->nama)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Size &mdash; {{ $komoditi->nama }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Nama Size</th>
                                <th>Status</th>
                                <th>Diusulkan Oleh</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sizes as $item)
                                @php
                                    $warnaStatus = ['disetujui' => 'success', 'menunggu_approval' => 'warning', 'ditolak' => 'danger'];
                                @endphp
                                <tr>
                                    <td>{{ $item->urutan ?? '-' }}</td>
                                    <td>{{ $item->nama_size }}</td>
                                    <td>
                                        <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }}">
                                            {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->pengusul->name ?? '-' }}</td>
                                    <td class="text-right">
                                        @if ($item->status === 'menunggu_approval')
                                            <form method="POST" action="{{ route('komoditi.size.approve', [$komoditi, $item]) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-success">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('komoditi.size.tolak', [$komoditi, $item]) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada size untuk komoditi ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Size Baru</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Input langsung oleh Admin/Pusat otomatis disetujui. Isi "Urutan" pakai jarak
                    (mis. 10, 20, 30) supaya nanti gampang disisipi size baru di tengah tanpa geser
                    ulang semua data. Boleh dikosongkan.
                </div>
                <form method="POST" action="{{ route('komoditi.size.store', $komoditi) }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Size <span class="text-danger">*</span></label>
                        <input type="text" name="nama_size" value="{{ old('nama_size') }}" class="form-control @error('nama_size') is-invalid @enderror" placeholder="mis. 1000UP, 500-1000">
                        @error('nama_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Urutan (opsional)</label>
                        <input type="number" name="urutan" value="{{ old('urutan') }}" class="form-control" placeholder="mis. 10">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah & Setujui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
