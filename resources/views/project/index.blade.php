@extends('layouts.app')

@section('title', 'Project')

@section('content')
<div class="row mb-2">
    <div class="col-md-6">
        <form method="GET">
            <select name="status" class="form-control selectric" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="sedang_diproses" @selected(request('status')=='sedang_diproses')>Sedang Diproses</option>
                <option value="selesai" @selected(request('status')=='selesai')>Selesai</option>
                <option value="tutup" @selected(request('status')=='tutup')>Tutup</option>
            </select>
        </form>
    </div>
</div>

@if (auth()->user()->hasRole('Cabang'))
    <div class="alert alert-info">Menampilkan project yang melibatkan penawaran/permintaan cabang Anda saja.</div>
@endif

@php
    $labelStatus = ['sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
    $warnaStatus = ['sedang_diproses' => 'primary', 'selesai' => 'success', 'tutup' => 'secondary'];
@endphp

<div class="row">
    @forelse ($projects as $project)
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">Project #{{ $project->id }}</h5>
                        <span class="badge badge-{{ $warnaStatus[$project->status] ?? 'secondary' }}">
                            {{ $labelStatus[$project->status] ?? ucfirst($project->status) }}
                        </span>
                    </div>

                    <div class="small mb-1">
                        <span class="text-muted">Penawaran:</span>
                        <a href="{{ route('penawaran.show', $project->penawaran) }}">{{ $project->penawaran->judul }}</a>
                        <span class="text-muted">({{ $project->penawaran->user->cabang->nama_cabang ?? '-' }})</span>
                    </div>
                    <div class="small mb-2">
                        <span class="text-muted">Permintaan:</span>
                        <a href="{{ route('permintaan.show', $project->permintaan) }}">{{ $project->permintaan->judul }}</a>
                        <span class="text-muted">({{ $project->permintaan->user->cabang->nama_cabang ?? 'Pusat' }})</span>
                    </div>

                    <div class="text-muted small mb-3">
                        Dipilih oleh {{ $project->pemilih->name ?? '-' }} &middot; {{ $project->created_at->translatedFormat('d M Y, H:i') }}
                    </div>

                    <a href="{{ route('project.show', $project) }}" class="btn btn-sm btn-primary">Detail & Catatan Progress</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada Project. Project akan muncul di sini setelah Pusat/Admin memilih kandidat kecocokan di halaman Kecocokan.</div>
        </div>
    @endforelse
</div>

<div class="mt-3">{{ $projects->links('pagination::bootstrap-4') }}</div>
@endsection
