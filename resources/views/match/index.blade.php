@extends('layouts.app')

@section('title', 'Kecocokan Penawaran & Permintaan')

@section('content')
<div class="card mb-3">
    <div class="card-body py-3">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <form method="GET" id="form-filter-match">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2 mb-lg-0">
                            <select name="penawaran_id" class="form-control select2" data-placeholder="Filter per Penawaran..." onchange="document.getElementById('form-filter-match').submit()">
                                <option value=""></option>
                                @foreach ($opsiPenawaran as $opsi)
                                    <option value="{{ $opsi->id }}" @selected(request('penawaran_id')==$opsi->id)>{{ $opsi->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 mb-lg-0">
                            <select name="permintaan_id" class="form-control select2" data-placeholder="Filter per Permintaan..." onchange="document.getElementById('form-filter-match').submit()">
                                <option value=""></option>
                                @foreach ($opsiPermintaan as $opsi)
                                    <option value="{{ $opsi->id }}" @selected(request('permintaan_id')==$opsi->id)>{{ $opsi->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 mb-lg-0">
                            <select name="status" class="form-control selectric" onchange="document.getElementById('form-filter-match').submit()">
                                <option value="">Semua Status</option>
                                <option value="terbuka" @selected(request('status')=='terbuka')>Terbuka (belum dipilih)</option>
                                <option value="dipilih" @selected(request('status')=='dipilih')>Sudah Dipilih (Project)</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            @if (request()->anyFilled(['penawaran_id', 'permintaan_id', 'status']))
                                <a href="{{ route('match.index') }}" class="btn btn-secondary btn-block" title="Reset Filter"><i class="fas fa-times"></i></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 mt-2 mt-lg-0">
                <form method="POST" action="{{ route('match.jalankan') }}">
                    @csrf
                    <button class="btn btn-primary btn-block"><i class="fas fa-sync-alt"></i> Cari Kecocokan Ulang</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (request()->filled('penawaran_id') || request()->filled('permintaan_id'))
    <div class="alert alert-secondary">
        Menampilkan <strong>{{ $matches->total() }}</strong> pasangan kandidat
        @if (request()->filled('penawaran_id'))
            untuk Penawaran: <strong>{{ optional($opsiPenawaran->firstWhere('id', request('penawaran_id')))->judul }}</strong>
        @endif
        @if (request()->filled('permintaan_id'))
            {{ request()->filled('penawaran_id') ? '&' : 'untuk' }} Permintaan: <strong>{{ optional($opsiPermintaan->firstWhere('id', request('permintaan_id')))->judul }}</strong>
        @endif
    </div>
@endif

@if (auth()->user()->hasRole('Cabang'))
    <div class="alert alert-info">Menampilkan kecocokan yang melibatkan penawaran/permintaan cabang Anda saja.</div>
@endif

@if (auth()->user()->hasAnyRole(['Pusat', 'Admin']))
    <div class="alert alert-warning">
        <i class="fas fa-info-circle"></i> Setiap pasangan kecocokan (Lokal maupun Ekspor) harus Anda
        pilih secara manual untuk dijadikan Project. Kalau 1 Permintaan punya beberapa kandidat dari
        cabang berbeda, pilih salah satu yang paling sesuai — kandidat lain akan otomatis hilang dari
        daftar ini setelah Permintaan/Penawaran terkait terkunci.
    </div>
@endif

@php
    $labelStatus = ['terbuka' => 'Terbuka', 'dipilih' => 'Sudah Dipilih'];
    $warnaStatus = ['terbuka' => 'warning', 'dipilih' => 'success'];
@endphp

@forelse ($matches as $match)
    <div class="card">
        <div class="card-body">
            @if ($match->jumlah_size_cocok > 1)
                <div class="mb-2">
                    <span class="badge badge-secondary"><i class="fas fa-layer-group"></i> {{ $match->jumlah_size_cocok }} size cocok di pasangan ini</span>
                </div>
            @endif
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="text-muted small font-weight-bold">PENAWARAN</div>
                    <a href="{{ route('penawaran.show', $match->penawaran) }}"><strong>{{ $match->penawaran->judul }}</strong></a>
                    <div class="small text-muted">
                        {{ $match->penawaran->komoditi->nama ?? '-' }} &middot; {{ $match->penawaran->user->cabang->nama_cabang ?? '-' }}
                    </div>
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
                @if ($match->status === 'dipilih' && $match->project)
                    <a href="{{ route('project.show', $match->project) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-folder-open"></i> Lihat Project
                    </a>
                @else
                    <a href="{{ route('match.show', $match) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat Detail & Bandingkan
                    </a>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">Belum ada kecocokan ditemukan. Coba klik "Cari Kecocokan Ulang".</div>
@endforelse

<div class="mt-3">{{ $matches->links('pagination::bootstrap-4') }}</div>
@endsection
