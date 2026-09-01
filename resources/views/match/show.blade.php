@extends('layouts.app')

@section('title', 'Preview Kecocokan')

@section('content')
@php
    $labelStatus = ['terbuka' => 'Terbuka', 'dipilih' => 'Sudah Dipilih'];
    $warnaStatus = ['terbuka' => 'warning', 'dipilih' => 'success'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-0">Preview Kecocokan</h3>
        <span class="badge badge-{{ $warnaStatus[$match->status] ?? 'secondary' }}">
            {{ $labelStatus[$match->status] ?? ucfirst($match->status) }}
        </span>
        <span class="text-muted small ml-2">Skor: {{ $match->skor_matching }}</span>
    </div>
    <a href="{{ route('match.index') }}" class="btn btn-link">&larr; Kembali ke daftar</a>
</div>

@if ($match->status === 'dipilih' && $match->project)
    <div class="alert alert-primary">
        <i class="fas fa-check-circle"></i> Kandidat ini sudah dipilih dan menjadi
        <a href="{{ route('project.show', $match->project) }}"><strong>Project #{{ $match->project->id }}</strong></a>.
    </div>
@endif

<div class="row">
    <!-- PENAWARAN -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h4 class="mb-0">Penawaran</h4>
            </div>
            <div class="card-body">
                <h5><a href="{{ route('penawaran.show', $match->penawaran) }}" target="_blank">{{ $match->penawaran->judul }}</a></h5>
                <div class="mb-2">
                    <span class="badge badge-info">{{ $match->penawaran->tipe }}</span>
                    <span class="badge badge-purple">{{ $match->penawaran->jenis_penawaran }}</span>
                </div>

                <dl class="row small">
                    <dt class="col-5">Komoditi</dt>
                    <dd class="col-7">{{ $match->penawaran->komoditi->nama ?? '-' }}</dd>

                    <dt class="col-5">Kondisi Ikan</dt>
                    <dd class="col-7">{{ $match->penawaran->kondisi_ikan ?? '-' }}</dd>

                    <dt class="col-5">Cabang</dt>
                    <dd class="col-7">{{ $match->penawaran->user->cabang->nama_cabang ?? '-' }}</dd>

                    <dt class="col-5">Dibuat Oleh</dt>
                    <dd class="col-7">{{ $match->penawaran->user->name }}</dd>
                </dl>

                @if ($match->penawaran->keterangan)
                    <div class="text-muted small mb-3">{{ $match->penawaran->keterangan }}</div>
                @endif

                <hr>
                <h6>Size yang Cocok di Kandidat Ini</h6>
                @if ($match->penawaranRincian)
                    <div class="alert alert-success py-2 px-3 mb-3">
                        <strong>{{ $match->penawaranRincian->komoditiSize->nama_size ?? '-' }}</strong><br>
                        Rp {{ number_format($match->penawaranRincian->harga_jual, 0) }}/kg
                        &middot; {{ number_format($match->penawaranRincian->kuantiti, 0) }} kg tersedia
                    </div>
                @endif

                <h6>Seluruh Rincian Size di Penawaran Ini</h6>
                <div class="text-muted small mb-2">
                    Ingat: kalau kandidat ini dipilih, SELURUH penawaran ini terkunci, termasuk size
                    lain di bawah ini yang belum tentu ikut laku ke Permintaan ini.
                </div>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Size</th><th>Harga Jual/kg</th><th>Kuantiti</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($match->penawaran->rincianSize as $rincian)
                            <tr class="{{ $rincian->id === $match->penawaran_rincian_id ? 'table-success' : '' }}">
                                <td>{{ $rincian->komoditiSize->nama_size ?? '-' }}</td>
                                <td>Rp {{ number_format($rincian->harga_jual, 0) }}</td>
                                <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($match->penawaran->detailEkspor)
                    <h6>Detail Ekspor</h6>
                    <dl class="row small">
                        <dt class="col-5">Sertifikasi</dt>
                        <dd class="col-7">{{ $match->penawaran->detailEkspor->sertifikasi ?? '-' }}</dd>
                        <dt class="col-5">Kontinuitas Suplai</dt>
                        <dd class="col-7">{{ $match->penawaran->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>
                        <dt class="col-5">Negara Tujuan</dt>
                        <dd class="col-7">{{ $match->penawaran->detailEkspor->negara_tujuan ?? '-' }}</dd>
                    </dl>
                @endif

                @if ($match->penawaran->user->whatsapp_link)
                    <a href="{{ $match->penawaran->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                        <i class="fab fa-whatsapp"></i> Hubungi {{ $match->penawaran->user->name }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- PERMINTAAN -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h4 class="mb-0">Permintaan</h4>
            </div>
            <div class="card-body">
                <h5><a href="{{ route('permintaan.show', $match->permintaan) }}" target="_blank">{{ $match->permintaan->judul }}</a></h5>
                <div class="mb-2">
                    <span class="badge badge-info">{{ $match->permintaan->tipe }}</span>
                    @if ($match->permintaan->prioritas_warna)
                        @php $warnaPrioritas = ['merah' => 'danger', 'kuning' => 'warning', 'hijau' => 'success']; @endphp
                        <span class="badge badge-{{ $warnaPrioritas[$match->permintaan->prioritas_warna] ?? 'secondary' }}">
                            Prioritas: {{ ucfirst($match->permintaan->prioritas_warna) }}
                        </span>
                    @endif
                </div>

                @if ($match->permintaan->prioritas_tag)
                    <div class="alert alert-warning py-2 px-3">{{ $match->permintaan->prioritas_tag }}</div>
                @endif

                <dl class="row small">
                    <dt class="col-5">Komoditi</dt>
                    <dd class="col-7">{{ $match->permintaan->komoditi->nama ?? '-' }}</dd>

                    <dt class="col-5">Cabang / Buyer</dt>
                    <dd class="col-7">{{ $match->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}</dd>

                    <dt class="col-5">Dibuat Oleh</dt>
                    <dd class="col-7">{{ $match->permintaan->user->name }}</dd>
                </dl>

                @if ($match->permintaan->keterangan)
                    <div class="text-muted small mb-3">{{ $match->permintaan->keterangan }}</div>
                @endif

                <hr>
                <h6>Size yang Cocok di Kandidat Ini</h6>
                @if ($match->permintaanRincian)
                    <div class="alert alert-success py-2 px-3 mb-3">
                        <strong>{{ $match->permintaanRincian->komoditiSize->nama_size ?? '-' }}</strong><br>
                        Rp {{ number_format($match->permintaanRincian->harga, 0) }}/kg
                        &middot; {{ number_format($match->permintaanRincian->kuantiti, 0) }} kg dibutuhkan
                    </div>
                @endif

                <h6>Seluruh Rincian Size di Permintaan Ini</h6>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Size</th><th>Harga/kg</th><th>Kuantiti</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($match->permintaan->rincianSize as $rincian)
                            <tr class="{{ $rincian->id === $match->permintaan_rincian_id ? 'table-success' : '' }}">
                                <td>{{ $rincian->komoditiSize->nama_size ?? '-' }}</td>
                                <td>Rp {{ number_format($rincian->harga, 0) }}</td>
                                <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($match->permintaan->detailEkspor)
                    <h6>Detail Ekspor</h6>
                    <dl class="row small">
                        <dt class="col-5">Sertifikasi</dt>
                        <dd class="col-7">{{ $match->permintaan->detailEkspor->sertifikasi ?? '-' }}</dd>
                        <dt class="col-5">Kontinuitas Suplai</dt>
                        <dd class="col-7">{{ $match->permintaan->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>
                        <dt class="col-5">Negara Tujuan</dt>
                        <dd class="col-7">{{ $match->permintaan->detailEkspor->negara_tujuan ?? '-' }}</dd>
                    </dl>
                @endif

                @if ($match->permintaan->user->whatsapp_link)
                    <a href="{{ $match->permintaan->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                        <i class="fab fa-whatsapp"></i> Hubungi {{ $match->permintaan->user->name }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan perbandingan singkat -->
<div class="card mt-3">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="text-muted small">Harga Jual Penawaran</div>
                <h4 class="mb-0">Rp {{ number_format($match->penawaranRincian->harga_jual ?? 0, 0) }}</h4>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Harga Permintaan</div>
                <h4 class="mb-0">Rp {{ number_format($match->permintaanRincian->harga ?? 0, 0) }}</h4>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Selisih Kuantiti</div>
                @php
                    $kuantitiPenawaran = $match->penawaranRincian->kuantiti ?? 0;
                    $kuantitiPermintaan = $match->permintaanRincian->kuantiti ?? 0;
                    $selisih = $kuantitiPenawaran - $kuantitiPermintaan;
                @endphp
                <h4 class="mb-0 {{ $selisih >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih, 0) }} kg
                </h4>
                <div class="text-muted small">
                    {{ $selisih >= 0 ? 'Stok cukup/lebih' : 'Stok kurang dari kebutuhan' }}
                </div>
            </div>
        </div>
    </div>
</div>

@if ($match->status === 'terbuka' && auth()->user()->hasAnyRole(['Pusat', 'Admin']))
    <div class="card mt-3">
        <div class="card-body text-center">
            <p class="text-muted mb-3">
                Setelah dipilih, Penawaran & Permintaan di atas akan langsung terkunci sepenuhnya
                (termasuk size lain yang belum laku) dan sebuah Project baru akan dibuat.
            </p>
            <form method="POST" action="{{ route('match.pilih', $match) }}" onsubmit="return confirm('Pilih kandidat ini sebagai pemenang? Penawaran & Permintaan terkait akan langsung terkunci dan jadi Project.')">
                @csrf
                <button class="btn btn-success btn-lg"><i class="fas fa-check"></i> Pilih Jadi Project</button>
            </form>
        </div>
    </div>
@endif
@endsection
