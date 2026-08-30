@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-fish"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Penawaran Tersedia</h4>
                </div>
                <div class="card-body">
                    {{ $totalPenawaranTersedia }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Permintaan Tersedia</h4>
                </div>
                <div class="card-body">
                    {{ $totalPermintaanTersedia }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Match Ekspor Menunggu Review</h4>
                </div>
                <div class="card-body">
                    {{ $matchMenungguReview }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Penawaran Terbaru</h4>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($penawaranTerbaru as $item)
                    <a href="{{ route('penawaran.show', $item) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ $item->judul }}</div>
                            <span class="badge badge-info">{{ $item->tipe }}</span>
                        </div>
                        <div class="text-muted small">{{ $item->user->cabang->nama_cabang ?? '-' }}</div>
                    </a>
                @empty
                    <div class="list-group-item text-muted">Belum ada penawaran.</div>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Permintaan Terbaru</h4>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($permintaanTerbaru as $item)
                    <a href="{{ route('permintaan.show', $item) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ $item->judul }}</div>
                            <span class="badge badge-info">{{ $item->tipe }}</span>
                        </div>
                        <div class="text-muted small">{{ $item->user->cabang->nama_cabang ?? 'Pusat' }}</div>
                    </a>
                @empty
                    <div class="list-group-item text-muted">Belum ada permintaan.</div>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
