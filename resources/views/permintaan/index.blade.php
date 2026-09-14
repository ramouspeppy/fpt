@extends('layouts.app')

@section('title', 'Daftar Permintaan')

@section('content')
<x-listing-card-styles />

<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7 mb-2 mb-md-0">
                    <input type="text" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari komoditi / judul / nama daerah...">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <select name="tipe" class="form-control selectric">
                        <option value="">Semua Tipe</option>
                        <option value="Ekspor" @selected(request('tipe')=='Ekspor')>Ekspor</option>
                        <option value="Lokal" @selected(request('tipe')=='Lokal')>Lokal</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <button class="btn btn-secondary btn-block">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('permintaan.create') }}" class="btn btn-info">
        <i class="fas fa-plus"></i> Tambah Permintaan
    </a>
</div>

<div class="row">
    @forelse ($permintaan as $item)
        @php
            $warnaStatus = ['tersedia' => 'success', 'sedang_diproses' => 'primary', 'selesai' => 'dark', 'tutup' => 'secondary'];
            $labelStatus = ['tersedia' => 'Tersedia', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
            $warnaPrioritas = ['merah' => '#dc3545', 'kuning' => '#ffc107', 'hijau' => '#28a745'];
            $namaLain = $item->komoditi?->tags->pluck('nama_tag')->filter()->unique();
            // Fallback foto: galeri Permintaan sendiri -> foto Komoditi -> placeholder ikon
            $gambarUrl = $item->getFirstMediaUrl('foto', 'thumb') ?: $item->komoditi?->fotoUtama()?->getUrl('thumb');
        @endphp
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card listing-card h-100 shadow-sm position-relative">
                @if ($item->prioritas_warna)
                    <div class="listing-card-priority" style="background-color: {{ $warnaPrioritas[$item->prioritas_warna] ?? '#ccc' }};"></div>
                @endif
                <div class="listing-card-image">
                    @if ($gambarUrl)
                        <img src="{{ $gambarUrl }}" alt="{{ $item->komoditi->nama ?? $item->judul }}">
                    @else
                        <div class="listing-card-image-placeholder"><i class="fas fa-fish"></i></div>
                    @endif
                    <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }} listing-card-status">
                        {{ $labelStatus[$item->status] ?? ucfirst($item->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $item->judul }}</h5>
                    <div class="listing-card-meta">
                        <span class="badge listing-badge-tipe listing-badge-tipe-{{ \Illuminate\Support\Str::slug($item->tipe) }}">{{ $item->tipe }}</span>
                        <span class="listing-card-komoditi">{{ $item->komoditi->nama ?? '-' }}</span>
                        @if ($item->sudah_terkunci)
                            <span class="badge badge-dark"><i class="fas fa-lock"></i> Project</span>
                        @endif
                    </div>

                    @if ($namaLain && $namaLain->isNotEmpty())
                        <div class="listing-card-altname">
                            <i class="fas fa-tag"></i>
                            <span class="morphext" data-effect="fadeIn">{{ $namaLain->implode(', ') }}</span>
                        </div>
                    @endif

                    <div class="listing-card-divider"></div>

                    <div class="listing-card-row mb-2">
                        <span class="badge badge-info">{{ $item->rincianSize->count() }} size</span>
                        <span class="listing-card-stat-value">{{ number_format($item->total_volume, 0) }} kg</span>
                    </div>
                    <div class="listing-card-row">
                        <span class="listing-card-stat-label">Harga</span>
                        <span class="listing-card-stat-value">{{ $item->rentang_harga }} / kg</span>
                    </div>
                    @if ($item->prioritas_tag)
                        <div class="listing-card-row mt-2">
                            <span class="listing-card-stat-label">Prioritas</span>
                            <span class="badge badge-warning">{{ $item->prioritas_tag }}</span>
                        </div>
                    @endif

                    <div class="listing-card-divider"></div>

                    <div class="listing-card-footer">
                        <div class="listing-card-row mb-3">
                            <div class="d-flex align-items-center" style="gap: 0.6rem;">
                                <div class="listing-card-avatar">{{ strtoupper(substr($item->user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="listing-card-user-name">{{ $item->user->name }}</div>
                                    <div class="listing-card-user-branch">{{ $item->user->cabang->nama_cabang ?? 'Pusat' }}</div>
                                </div>
                            </div>
                            @if ($item->user->whatsapp_link)
                                <a href="{{ $item->user->whatsapp_link }}" target="_blank" class="listing-card-whatsapp" title="Hubungi via WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>

                        <div class="listing-card-actions">
                            <a href="{{ route('permintaan.show', $item) }}" class="btn btn-sm btn-primary">Detail</a>
                            @if ((auth()->id() === $item->user_id || auth()->user()->hasRole('Admin')) && !$item->sudah_terkunci)
                                <a href="{{ route('permintaan.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada permintaan.</div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $permintaan->links('pagination::bootstrap-4') }}
</div>
@endsection
