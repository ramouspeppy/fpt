@extends('layouts.app')

@section('title', 'Master Data Komoditi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Komoditi</h4>
                <div class="card-header-form">
                    <form method="GET">
                        <select name="status" class="form-control selectric" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="menunggu_approval" @selected(request('status')=='menunggu_approval')>Menunggu Approval</option>
                            <option value="disetujui" @selected(request('status')=='disetujui')>Disetujui</option>
                            <option value="ditolak" @selected(request('status')=='ditolak')>Ditolak</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Diusulkan Oleh</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($komoditi as $item)
                                @php
                                    $warnaStatus = ['disetujui' => 'success', 'menunggu_approval' => 'warning', 'ditolak' => 'danger'];
                                @endphp
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kategori ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }}">
                                            {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->pengusul->name ?? '-' }}</td>
                                    <td class="text-right">
                                        @if ($item->status === 'disetujui')
                                            <a href="{{ route('komoditi.size.index', $item) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-ruler"></i> Kelola Size
                                            </a>
                                        @endif
                                        @if ($item->status === 'menunggu_approval')
                                            <form method="POST" action="{{ route('komoditi.approve', $item) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-success">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('komoditi.tolak', $item) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $komoditi->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Komoditi Baru</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">Input langsung oleh Admin/Pusat otomatis disetujui, tidak perlu approval.</div>
                <form method="POST" action="{{ route('komoditi.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Komoditi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control" placeholder="mis. Ikan, Udang, Kepiting, Cumi & Gurita">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah & Setujui</button>
                </form>
                <div class="text-muted small mt-3">
                    Setelah komoditi disetujui, klik <strong>Kelola Size</strong> di baris komoditi
                    tersebut untuk menambahkan daftar size-nya (mis. 1000UP, 500-1000, dst).
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
