@extends('layouts.app')

@section('title', 'Kecocokan Penawaran & Permintaan')

@section('content')
<div class="row mb-2">
    <div class="col-md-6">
        <form method="GET">
            <select name="status" class="form-control selectric" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="menunggu_review" @selected(request('status')=='menunggu_review')>Menunggu Review (Ekspor)</option>
                <option value="notifikasi_otomatis" @selected(request('status')=='notifikasi_otomatis')>Notifikasi Otomatis (Lokal)</option>
                <option value="disetujui" @selected(request('status')=='disetujui')>Disetujui Pusat</option>
                <option value="ditolak" @selected(request('status')=='ditolak')>Ditolak</option>
            </select>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <form method="POST" action="{{ route('match.jalankan') }}">
            @csrf
            <button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Cari Kecocokan Ulang</button>
        </form>
    </div>
</div>

@if (auth()->user()->hasRole('Cabang'))
    <div class="alert alert-info">Menampilkan kecocokan yang melibatkan penawaran/permintaan cabang Anda saja.</div>
@endif

@php
    $labelStatus = [
        'menunggu_review' => 'Menunggu Review',
        'notifikasi_otomatis' => 'Notifikasi Otomatis',
        'disetujui' => 'Disetujui Pusat',
        'ditolak' => 'Ditolak',
    ];
    $warnaStatus = [
        'menunggu_review' => 'warning',
        'notifikasi_otomatis' => 'info',
        'disetujui' => 'success',
        'ditolak' => 'danger',
    ];
@endphp

@forelse ($matches as $match)
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="text-muted small font-weight-bold">PENAWARAN</div>
                    <a href="{{ route('penawaran.show', $match->penawaran) }}"><strong>{{ $match->penawaran->judul }}</strong></a>
                    <div class="small text-muted">
                        {{ $match->penawaran->komoditi->nama ?? '-' }} &middot; {{ $match->penawaran->user->cabang->nama_cabang ?? '-' }}
                    </div>
                    @if ($match->penawaranRincian)
                        <div class="mt-1">
                            <span class="badge badge-info">Grade: {{ $match->penawaranRincian->ukuran_grade }}</span>
                            <span class="text-muted small">
                                Rp {{ number_format($match->penawaranRincian->harga, 0) }}/kg
                                &middot; {{ number_format($match->penawaranRincian->kuantiti, 0) }} kg
                            </span>
                        </div>
                    @endif
                </div>
                <div class="col-md-2 text-center d-none d-md-block">
                    <i class="fas fa-exchange-alt fa-2x text-muted"></i>
                </div>
                <div class="col-md-5">
                    <div class="text-muted small font-weight-bold">PERMINTAAN</div>
                    <a href="{{ route('permintaan.show', $match->permintaan) }}"><strong>{{ $match->permintaan->judul }}</strong></a>
                    <div class="small text-muted">
                        {{ $match->permintaan->komoditi->nama ?? '-' }} &middot; {{ $match->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}
                    </div>
                    @if ($match->permintaanRincian)
                        <div class="mt-1">
                            <span class="badge badge-info">Grade: {{ $match->permintaanRincian->ukuran_grade }}</span>
                            <span class="text-muted small">
                                Rp {{ number_format($match->permintaanRincian->harga, 0) }}/kg
                                &middot; {{ number_format($match->permintaanRincian->kuantiti, 0) }} kg
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge badge-{{ $warnaStatus[$match->status] ?? 'secondary' }}">
                        {{ $labelStatus[$match->status] ?? ucfirst($match->status) }}
                    </span>
                    <span class="text-muted small ml-2">Skor: {{ $match->skor_matching }}</span>
                </div>
                @if ($match->status === 'menunggu_review' && auth()->user()->hasAnyRole(['Pusat', 'Admin']))
                    <div>
                        <form method="POST" action="{{ route('match.approve', $match) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('match.tolak', $match) }}" class="d-inline" onsubmit="return confirm('Tolak match ini?')">
                            @csrf
                            <button class="btn btn-sm btn-danger">Tolak</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">Belum ada kecocokan ditemukan. Coba klik "Cari Kecocokan Ulang".</div>
@endforelse

<div class="mt-3">{{ $matches->links('pagination::bootstrap-4') }}</div>
@endsection
