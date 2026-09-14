@extends('layouts.app')

@section('title', 'Daftar Penawaran')

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item">Penawaran</div>
@endsection

@section('content')
    <x-listing-card-styles />

    <div class="mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <div class="text-uppercase text-muted small font-weight-bold mb-1">Daftar komoditi</div>
                        <h4 class="mb-0">Penawaran aktif</h4>
                    </div>
                    <a href="{{ route('penawaran.create') }}" class="btn btn-primary btn-icon icon-left mt-3 mt-md-0">
                        <i class="fas fa-plus"></i> Tambah Penawaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form method="GET">
                <div class="row align-items-end">
                    <div class="col-lg-5 col-md-12 mb-3 mb-lg-0">
                        <label class="form-label text-muted small font-weight-bold mb-2">Pencarian</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari komoditi / judul / nama daerah...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="form-label text-muted small font-weight-bold mb-2">Tipe</label>
                        <select name="tipe" class="form-control selectric">
                            <option value="">Semua Tipe</option>
                            <option value="Ekspor" @selected(request('tipe') == 'Ekspor')>Ekspor</option>
                            <option value="Lokal" @selected(request('tipe') == 'Lokal')>Lokal</option>
                            <option value="Ekspor & Lokal" @selected(request('tipe') == 'Ekspor & Lokal')>Ekspor & Lokal</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="form-label text-muted small font-weight-bold mb-2">Status</label>
                        <select name="status" class="form-control selectric">
                            <option value="">Semua Status</option>
                            <option value="tersedia" @selected(request('status') == 'tersedia')>Tersedia</option>
                            <option value="sedang_diproses" @selected(request('status') == 'sedang_diproses')>Sedang Diproses</option>
                            <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
                            <option value="tutup" @selected(request('status') == 'tutup')>Tutup</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request()->anyFilled(['cari', 'tipe', 'status']))
        <div class="mb-3">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="text-muted">Filter aktif:</span>
                @if (request('cari'))
                    <span class="badge badge-info">{{ request('cari') }}</span>
                @endif
                @if (request('tipe'))
                    <span class="badge badge-primary">{{ request('tipe') }}</span>
                @endif
                @if (request('status'))
                    @php $labelStatus = ['tersedia' => 'Tersedia', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup']; @endphp
                    <span class="badge badge-secondary">{{ $labelStatus[request('status')] ?? request('status') }}</span>
                @endif
                <a href="{{ route('penawaran.index') }}" class="small text-muted">reset</a>
            </div>
        </div>
    @endif

    <div class="row">
        @forelse ($penawaran as $item)
            @php
                $warnaStatus = ['tersedia' => 'success', 'sedang_diproses' => 'primary', 'selesai' => 'dark', 'tutup' => 'secondary'];
                $labelStatus = ['tersedia' => 'Tersedia', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
                $namaLain = $item->komoditi?->tags->pluck('nama_tag')->filter()->unique();
                $gambarUrl = $item->getFirstMediaUrl('foto', 'thumb') ?: $item->komoditi?->fotoUtama()?->getUrl('thumb');
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card listing-card h-100 shadow-sm border-0">
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
                            @if ($item->jenis_penawaran === 'Trading')
                                <span class="badge badge-purple">Trading</span>
                            @endif
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

                        <div class="listing-card-divider"></div>

                        <div class="listing-card-footer">
                            <div class="listing-card-row mb-3">
                                <div class="d-flex align-items-center" style="gap: 0.6rem;">
                                    <div class="listing-card-avatar">{{ strtoupper(substr($item->user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="listing-card-user-name">{{ $item->user->name }}</div>
                                        <div class="listing-card-user-branch">{{ $item->user->cabang->nama_cabang ?? '-' }}</div>
                                    </div>
                                </div>
                                @if ($item->user->whatsapp_link)
                                    <a href="{{ $item->user->whatsapp_link }}" target="_blank" class="listing-card-whatsapp" title="Hubungi via WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="listing-card-actions">
                                <a href="{{ route('penawaran.show', $item) }}" class="btn btn-sm btn-primary">Detail</a>
                                @if ((auth()->id() === $item->user_id || auth()->user()->hasRole('Admin')) && !$item->sudah_terkunci)
                                    <a href="{{ route('penawaran.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i> Belum ada penawaran yang sesuai dengan filter saat ini.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $penawaran->links('pagination::bootstrap-4') }}
    </div>
@endsection
