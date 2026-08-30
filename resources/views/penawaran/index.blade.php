@extends('layouts.app')

@section('title', 'Daftar Penawaran')

@section('content')
<div class="row mb-2">
    <div class="col-md-8">
        <form method="GET" class="form-inline">
            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control mr-2 mb-2" placeholder="Cari komoditi / judul...">
            <select name="tipe" class="form-control selectric mr-2 mb-2">
                <option value="">Semua Tipe</option>
                <option value="Ekspor" @selected(request('tipe')=='Ekspor')>Ekspor</option>
                <option value="Lokal" @selected(request('tipe')=='Lokal')>Lokal</option>
                <option value="Ekspor & Lokal" @selected(request('tipe')=='Ekspor & Lokal')>Ekspor & Lokal</option>
            </select>
            <button class="btn btn-secondary mb-2">Filter</button>
        </form>
    </div>
    <div class="col-md-4 text-right">
        <a href="{{ route('penawaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penawaran
        </a>
    </div>
</div>

<div class="row">
    @forelse ($penawaran as $item)
        @php
            $warnaStatus = ['tersedia' => 'success', 'matched' => 'primary', 'selesai' => 'dark', 'ditutup' => 'secondary'];
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title mb-1">{{ $item->judul }}</h5>
                        <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="text-muted small mb-2">
                        {{ $item->tipe }} &middot; {{ $item->komoditi->nama ?? '-' }}
                        @if ($item->jenis_penawaran === 'Trading')
                            <span class="badge badge-purple">Trading</span>
                        @endif
                    </div>

                    <div class="mb-2">
                        <span class="badge badge-info">{{ $item->rincianGrade->count() }} grade</span>
                        Total: <strong>{{ number_format($item->total_volume, 0) }} kg</strong>
                        <div class="text-muted small">{{ $item->rentang_harga }} / kg</div>
                    </div>

                    <div class="text-muted small">
                        Dibuat oleh: <strong>{{ $item->user->name }}</strong><br>
                        Cabang: {{ $item->user->cabang->nama_cabang ?? '-' }}<br>
                        @if ($item->user->whatsapp_link)
                            <a href="{{ $item->user->whatsapp_link }}" target="_blank" class="text-success">
                                <i class="fab fa-whatsapp"></i> {{ $item->user->no_whatsapp }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('penawaran.show', $item) }}" class="btn btn-sm btn-primary">Detail</a>
                        @if (auth()->id() === $item->user_id || auth()->user()->hasRole('Admin'))
                            <a href="{{ route('penawaran.edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
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
    {{ $penawaran->links('pagination::bootstrap-4') }}
</div>
@endsection
