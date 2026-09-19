@extends('layouts.app')

@section('title', 'Preview Kecocokan')

@section('content')
@php
    $labelStatus = ['terbuka' => 'Terbuka', 'dipilih' => 'Sudah Dipilih'];
    $warnaStatus = ['terbuka' => 'warning', 'dipilih' => 'emerald'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-0">Preview Kecocokan</h3>
        <span class="badge badge-{{ $warnaStatus[$match->status] ?? 'secondary' }}">
            {{ $labelStatus[$match->status] ?? ucfirst($match->status) }}
        </span>
        <span class="text-muted small ml-2">{{ $semuaKandidat->count() }} size cocok di pasangan ini</span>
    </div>
    <a href="{{ route('match.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali ke daftar</a>
</div>

@if ($match->status === 'dipilih' && $match->project)
    <div class="alert alert-primary">
        <i class="fas fa-check-circle"></i> Pasangan ini sudah dipilih dan menjadi
        <a href="{{ route('project.show', $match->project) }}"><strong>Project #{{ $match->project->id }}</strong></a>.
    </div>
@endif

<!-- Ringkasan semua size yang cocok di pasangan ini -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <h4 class="mb-0">Size yang Cocok di Pasangan Ini</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Harga Jual Penawaran</th>
                        <th>Kuantiti Penawaran</th>
                        <th>Harga Permintaan</th>
                        <th>Kuantiti Dibutuhkan</th>
                        <th>Selisih Kuantiti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semuaKandidat as $kandidat)
                        @php
                            $kuantitiPenawaran = $kandidat->penawaranRincian->kuantiti ?? 0;
                            $kuantitiPermintaan = $kandidat->permintaanRincian->kuantiti ?? 0;
                            $selisih = $kuantitiPenawaran - $kuantitiPermintaan;
                        @endphp
                        <tr>
                            <td><strong>{{ $kandidat->penawaranRincian->komoditiSize->nama_size ?? '-' }}</strong></td>
                            <td>Rp {{ number_format($kandidat->penawaranRincian->harga_jual ?? 0, 0) }}</td>
                            <td>{{ number_format($kuantitiPenawaran, 0) }} kg</td>
                            <td>Rp {{ number_format($kandidat->permintaanRincian->harga ?? 0, 0) }}</td>
                            <td>{{ number_format($kuantitiPermintaan, 0) }} kg</td>
                            <td class="{{ $selisih >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih, 0) }} kg
                                <span class="small">({{ $selisih >= 0 ? 'stok cukup' : 'stok kurang' }})</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
    $totalKg = $semuaKandidat->sum('kg_permintaan');
    $totalNilaiPermintaan = $semuaKandidat->sum('total_nilai_permintaan');
    $totalHpp = $semuaKandidat->sum('total_hpp');
    $estimasiProfit = $totalNilaiPermintaan - $totalHpp;
    $persenProfit = $totalNilaiPermintaan > 0 ? $estimasiProfit / $totalNilaiPermintaan : 0;
    $warnaProfit = $persenProfit * 100 < 10 ? 'danger' : ($persenProfit * 100 < 20 ? 'warning' : 'emerald');
@endphp

<!-- Tabel Estimasi Profit (setara "Tabel Hitung Margin" di excel gap_margin.xlsx) -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <h4 class="mb-0"><i class="fas fa-calculator"></i> Tabel Estimasi Profit</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>KG Permintaan</th>
                        <th>Harga HPP Penawaran</th>
                        <th>Total HPP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semuaKandidat as $kandidat)
                        <tr>
                            <td><strong>{{ $kandidat->permintaanRincian->komoditiSize->nama_size ?? '-' }}</strong></td>
                            <td>{{ number_format($kandidat->kg_permintaan, 0) }} kg</td>
                            <td>Rp {{ number_format($kandidat->harga_hpp_penawaran, 0) }}</td>
                            <td>Rp {{ number_format($kandidat->total_hpp, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total</td>
                        <td>{{ number_format($totalKg, 0) }} kg</td>
                        <td></td>
                        <td>Rp {{ number_format($totalHpp, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Ringkasan (setara "Ringkasan" di excel gap_margin.xlsx) -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <h4 class="mb-0"><i class="fas fa-chart-pie"></i> Ringkasan</h4>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-6 col-md-3">Total Permintaan</dt>
            <dd class="col-6 col-md-3">Rp {{ number_format($totalNilaiPermintaan, 0) }}</dd>

            <dt class="col-6 col-md-3">Total HPP</dt>
            <dd class="col-6 col-md-3">Rp {{ number_format($totalHpp, 0) }}</dd>

            <dt class="col-6 col-md-3">Estimasi Profit</dt>
            <dd class="col-6 col-md-3">Rp {{ number_format($estimasiProfit, 0) }}</dd>

            <dt class="col-6 col-md-3">% Profit</dt>
            <dd class="col-6 col-md-3">
                <span class="badge badge-{{ $warnaProfit }} p-2">{{ number_format($persenProfit * 100, 1) }}%</span>
            </dd>
        </dl>
    </div>
</div>

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
                <h6>Seluruh Rincian Size di Penawaran Ini</h6>
                <div class="text-muted small mb-2">
                    Baris yang disorot hijau = size yang cocok ke Permintaan ini (lihat tabel ringkasan
                    di atas). Ingat: kalau pasangan ini dipilih, SELURUH penawaran ini terkunci,
                    termasuk size lain di bawah ini yang belum tentu ikut laku.
                </div>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Size</th><th>Harga Jual/kg</th><th>Kuantiti</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($match->penawaran->rincianSize as $rincian)
                            <tr class="{{ $penawaranRincianIdCocok->contains($rincian->id) ? 'table-success' : '' }}">
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
                    <a href="{{ $match->penawaran->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-emerald">
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
                        @php $warnaPrioritas = ['merah' => 'danger', 'kuning' => 'warning', 'hijau' => 'emerald']; @endphp
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
                <h6>Seluruh Rincian Size di Permintaan Ini</h6>
                <div class="text-muted small mb-2">
                    Baris yang disorot hijau = size yang cocok ke Penawaran ini.
                </div>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Size</th><th>Harga/kg</th><th>Kuantiti</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($match->permintaan->rincianSize as $rincian)
                            <tr class="{{ $permintaanRincianIdCocok->contains($rincian->id) ? 'table-success' : '' }}">
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
                    <a href="{{ $match->permintaan->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-emerald">
                        <i class="fab fa-whatsapp"></i> Hubungi {{ $match->permintaan->user->name }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($match->status === 'terbuka' && auth()->user()->hasAnyRole(['Pusat', 'Admin']))
    <div class="card mt-3">
        <div class="card-body text-center">
            <p class="text-muted mb-3">
                Setelah dipilih, Penawaran & Permintaan di atas akan langsung terkunci sepenuhnya
                (termasuk size lain yang belum laku) dan sebuah Project baru akan dibuat. Semua size
                yang cocok di tabel ringkasan atas akan otomatis ikut ditandai final bersamaan.
            </p>
            <form method="POST" action="{{ route('match.pilih', $match) }}" onsubmit="return confirm('Pilih pasangan ini sebagai pemenang? Penawaran & Permintaan terkait akan langsung terkunci dan jadi Project.')">
                @csrf
                <button class="btn btn-emerald btn-lg"><i class="fas fa-check"></i> Pilih Jadi Project</button>
            </form>
        </div>
    </div>
@endif
@endsection
