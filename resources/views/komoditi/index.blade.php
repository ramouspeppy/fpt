@extends('layouts.app')

@section('title', 'Master Data Komoditi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" class="d-flex gap-2">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu_approval" @selected(request('status')=='menunggu_approval')>Menunggu Approval</option>
                    <option value="disetujui" @selected(request('status')=='disetujui')>Disetujui</option>
                    <option value="ditolak" @selected(request('status')=='ditolak')>Ditolak</option>
                </select>
            </form>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Diusulkan Oleh</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komoditi as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kategori ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'disetujui' ? 'green' : ($item->status == 'menunggu_approval' ? 'orange' : 'red') }}-lt">
                                        {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                    </span>
                                </td>
                                <td>{{ $item->pengusul->name ?? '-' }}</td>
                                <td class="text-end">
                                    @if ($item->status === 'menunggu_approval')
                                        <form method="POST" action="{{ route('komoditi.approve', $item) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('komoditi.tolak', $item) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger">Tolak</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $komoditi->links() }}</div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Tambah Komoditi Baru</h3>
                <div class="text-muted small mb-3">Input langsung oleh Admin/Pusat otomatis disetujui, tidak perlu approval.</div>
                <form method="POST" action="{{ route('komoditi.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label required">Nama Komoditi</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control" placeholder="mis. Ikan, Udang, Kepiting, Cumi & Gurita">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah & Setujui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
