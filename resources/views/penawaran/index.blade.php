@extends('layouts.app')

@section('title', 'Daftar Penawaran')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari jenis ikan / judul...">
        <select name="tipe" class="form-select">
            <option value="">Semua Tipe</option>
            <option value="Ekspor" @selected(request('tipe')=='Ekspor')>Ekspor</option>
            <option value="Lokal" @selected(request('tipe')=='Lokal')>Lokal</option>
            <option value="Ekspor & Lokal" @selected(request('tipe')=='Ekspor & Lokal')>Ekspor & Lokal</option>
        </select>
        <button class="btn btn-outline-secondary">Filter</button>
    </form>
    <a href="{{ route('penawaran.create') }}" class="btn btn-primary">
        <i class="ti ti-plus"></i> Tambah Penawaran
    </a>
</div>

<div class="row row-cards">
    @forelse ($penawaran as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-1">{{ $item->judul }}</h3>
                        <span class="badge bg-{{ $item->status == 'tersedia' ? 'green' : ($item->status == 'matched' ? 'blue' : 'secondary') }}-lt">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="text-muted small mb-2">{{ $item->tipe }} &middot; {{ $item->komoditi->nama ?? '-' }}</div>

                    <div class="mb-2">
                        <span class="badge bg-azure-lt">{{ $item->rincianGrade->count() }} grade</span>
                        Total: <strong>{{ number_format($item->total_volume, 0) }} kg</strong>
                        <div class="text-muted small">{{ $item->rentang_harga }} / kg</div>
                    </div>

                    <div class="text-muted small">
                        Dibuat oleh: <strong>{{ $item->user->name }}</strong><br>
                        Cabang: {{ $item->user->cabang->nama_cabang ?? '-' }}<br>
                        @if ($item->user->whatsapp_link)
                            <a href="{{ $item->user->whatsapp_link }}" target="_blank" class="text-success">
                                <i class="ti ti-brand-whatsapp"></i> {{ $item->user->no_whatsapp }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('penawaran.show', $item) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        @if (auth()->id() === $item->user_id || auth()->user()->hasRole('Admin'))
                            <a href="{{ route('penawaran.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada penawaran.</div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $penawaran->links() }}
</div>
@endsection
