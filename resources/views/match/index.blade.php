@extends('layouts.app')

@section('title', 'Kecocokan Penawaran & Permintaan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <form method="GET" class="d-flex gap-2">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="menunggu_review" @selected(request('status')=='menunggu_review')>Menunggu Review (Ekspor)</option>
            <option value="notifikasi_otomatis" @selected(request('status')=='notifikasi_otomatis')>Notifikasi Otomatis (Lokal)</option>
            <option value="disetujui" @selected(request('status')=='disetujui')>Disetujui Pusat</option>
            <option value="ditolak" @selected(request('status')=='ditolak')>Ditolak</option>
        </select>
    </form>

    <form method="POST" action="{{ route('match.jalankan') }}">
        @csrf
        <button class="btn btn-primary"><i class="ti ti-refresh"></i> Cari Kecocokan Ulang</button>
    </form>
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
        'menunggu_review' => 'orange',
        'notifikasi_otomatis' => 'blue',
        'disetujui' => 'green',
        'ditolak' => 'red',
    ];
@endphp

<div class="row row-cards">
    @forelse ($matches as $match)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="row flex-fill">
                            <div class="col-md-5">
                                <div class="text-muted small">PENAWARAN</div>
                                <a href="{{ route('penawaran.show', $match->penawaran) }}"><strong>{{ $match->penawaran->judul }}</strong></a>
                                <div class="small text-muted">
                                    {{ $match->penawaran->jenis_ikan }} &middot; {{ $match->penawaran->user->cabang->nama_cabang ?? '-' }}
                                </div>
                                @if ($match->penawaranRincian)
                                    <div class="mt-1">
                                        <span class="badge bg-azure-lt">Grade: {{ $match->penawaranRincian->ukuran_grade }}</span>
                                        <span class="text-muted small">
                                            Rp {{ number_format($match->penawaranRincian->harga, 0) }}/kg
                                            &middot; {{ number_format($match->penawaranRincian->kuantiti, 0) }} kg
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrows-left-right fs-2 text-muted"></i>
                            </div>
                            <div class="col-md-5">
                                <div class="text-muted small">PERMINTAAN</div>
                                <a href="{{ route('permintaan.show', $match->permintaan) }}"><strong>{{ $match->permintaan->judul }}</strong></a>
                                <div class="small text-muted">
                                    {{ $match->permintaan->jenis_ikan }} &middot; {{ $match->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}
                                </div>
                                @if ($match->permintaanRincian)
                                    <div class="mt-1">
                                        <span class="badge bg-azure-lt">Grade: {{ $match->permintaanRincian->ukuran_grade }}</span>
                                        <span class="text-muted small">
                                            Rp {{ number_format($match->permintaanRincian->harga, 0) }}/kg
                                            &middot; {{ number_format($match->permintaanRincian->kuantiti, 0) }} kg
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-end ms-3">
                            <div class="mb-1">
                                <span class="badge bg-{{ $warnaStatus[$match->status] ?? 'secondary' }}-lt">
                                    {{ $labelStatus[$match->status] ?? ucfirst($match->status) }}
                                </span>
                            </div>
                            <div class="text-muted small mb-2">Skor: {{ $match->skor_matching }}</div>

                            @if ($match->status === 'menunggu_review' && auth()->user()->hasAnyRole(['Pusat', 'Admin']))
                                <form method="POST" action="{{ route('match.approve', $match) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('match.tolak', $match) }}" class="d-inline" onsubmit="return confirm('Tolak match ini?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger">Tolak</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada kecocokan ditemukan. Coba klik "Cari Kecocokan Ulang".</div>
        </div>
    @endforelse
</div>

<div class="mt-3">{{ $matches->links() }}</div>
@endsection
