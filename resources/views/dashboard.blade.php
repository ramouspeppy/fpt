@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto"><span class="bg-green text-white avatar"><i class="ti ti-fish"></i></span></div>
                    <div class="col">
                        <div class="font-weight-medium">{{ $totalPenawaranTersedia }}</div>
                        <div class="text-muted">Penawaran Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto"><span class="bg-blue text-white avatar"><i class="ti ti-clipboard-list"></i></span></div>
                    <div class="col">
                        <div class="font-weight-medium">{{ $totalPermintaanTersedia }}</div>
                        <div class="text-muted">Permintaan Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto"><span class="bg-orange text-white avatar"><i class="ti ti-alert-triangle"></i></span></div>
                    <div class="col">
                        <div class="font-weight-medium">{{ $matchMenungguReview }}</div>
                        <div class="text-muted">Match Ekspor Menunggu Review</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Penawaran Terbaru</h3></div>
            <div class="list-group list-group-flush">
                @forelse ($penawaranTerbaru as $item)
                    <a href="{{ route('penawaran.show', $item) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <div>{{ $item->judul }}</div>
                            <span class="badge bg-azure-lt">{{ $item->tipe }}</span>
                        </div>
                        <div class="text-muted small">{{ $item->user->cabang->nama_cabang ?? '-' }}</div>
                    </a>
                @empty
                    <div class="list-group-item text-muted">Belum ada penawaran.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Permintaan Terbaru</h3></div>
            <div class="list-group list-group-flush">
                @forelse ($permintaanTerbaru as $item)
                    <a href="{{ route('permintaan.show', $item) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <div>{{ $item->judul }}</div>
                            <span class="badge bg-azure-lt">{{ $item->tipe }}</span>
                        </div>
                        <div class="text-muted small">{{ $item->user->cabang->nama_cabang ?? 'Pusat' }}</div>
                    </a>
                @empty
                    <div class="list-group-item text-muted">Belum ada permintaan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
