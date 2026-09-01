@extends('layouts.app')

@section('title', 'Detail Permintaan')

@section('content')
@php
    $warnaStatus = ['tersedia' => 'success', 'sedang_diproses' => 'primary', 'selesai' => 'dark', 'tutup' => 'secondary'];
    $labelStatus = ['tersedia' => 'Tersedia', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
    $warnaPrioritas = ['merah' => 'danger', 'kuning' => 'warning', 'hijau' => 'success'];
@endphp
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2>{{ $permintaan->judul }}</h2>
                <span class="badge badge-info">{{ $permintaan->tipe }}</span>
                <span class="badge badge-{{ $warnaStatus[$permintaan->status] ?? 'secondary' }}">
                    {{ $labelStatus[$permintaan->status] ?? ucfirst($permintaan->status) }}
                </span>
                @if ($permintaan->prioritas_warna)
                    <span class="badge badge-{{ $warnaPrioritas[$permintaan->prioritas_warna] ?? 'secondary' }}">
                        Prioritas: {{ ucfirst($permintaan->prioritas_warna) }}
                    </span>
                @endif
            </div>
            @if ((auth()->id() === $permintaan->user_id || auth()->user()->hasRole('Admin')) && !$permintaan->sudah_terkunci)
                <a href="{{ route('permintaan.edit', $permintaan) }}" class="btn btn-secondary">Edit</a>
            @endif
        </div>

        @if ($permintaan->project)
            <div class="alert alert-primary">
                <i class="fas fa-lock"></i> Permintaan ini sudah terkunci karena menjadi bagian dari
                <a href="{{ route('project.show', $permintaan->project) }}"><strong>Project #{{ $permintaan->project->id }}</strong></a>
                — tidak bisa diedit lagi.
            </div>
        @endif

        @if ($permintaan->prioritas_tag)
            <div class="alert alert-warning">{{ $permintaan->prioritas_tag }}</div>
        @endif

        <dl class="row">
            <dt class="col-3">Komoditi</dt>
            <dd class="col-9">{{ $permintaan->komoditi->nama ?? '-' }} <span class="text-muted small">({{ $permintaan->komoditi->kategori ?? '-' }})</span></dd>

            <dt class="col-3">Keterangan</dt>
            <dd class="col-9">{{ $permintaan->keterangan ?? '-' }}</dd>
        </dl>

        <hr>
        <h4>Rincian Size Dibutuhkan</h4>
        <div class="table-responsive mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Harga per kg</th>
                        <th>Kuantiti Dibutuhkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permintaan->rincianSize as $rincian)
                        <tr>
                            <td>{{ $rincian->komoditiSize->nama_size ?? '-' }}</td>
                            <td>Rp {{ number_format($rincian->harga, 0) }}</td>
                            <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total</td>
                        <td>{{ $permintaan->rentang_harga }}</td>
                        <td>{{ number_format($permintaan->total_volume, 0) }} kg</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ((auth()->id() === $permintaan->user_id || auth()->user()->hasRole('Admin')) && !$permintaan->sudah_terkunci)
            <hr>
            <h4>Ubah Status</h4>
            <div class="text-muted small mb-2">
                Status ini murni penanda kondisi nyata di lapangan — tidak diubah otomatis oleh sistem,
                jadi silakan update sendiri sesuai perkembangan komunikasi dengan pihak yang match.
            </div>
            <div class="btn-group" role="group">
                @foreach (['tersedia' => 'Tersedia', 'selesai' => 'Selesai', 'tutup' => 'Tutup'] as $nilai => $label)
                    <form method="POST" action="{{ route('permintaan.updateStatus', $permintaan) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nilai }}">
                        <button type="submit" class="btn btn-sm {{ $permintaan->status === $nilai ? 'btn-primary' : 'btn-secondary' }}">
                            {{ $label }}
                        </button>
                    </form>
                @endforeach
            </div>
        @endif

        @if ($permintaan->detailEkspor)
            <hr>
            <h4>Detail Ekspor</h4>
            <dl class="row">
                <dt class="col-3">Sertifikasi</dt>
                <dd class="col-9">{{ $permintaan->detailEkspor->sertifikasi ?? '-' }}</dd>

                <dt class="col-3">Kontinuitas Suplai</dt>
                <dd class="col-9">{{ $permintaan->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>

                <dt class="col-3">Negara Tujuan</dt>
                <dd class="col-9">{{ $permintaan->detailEkspor->negara_tujuan ?? '-' }}</dd>
            </dl>
        @endif

        <hr>
        <h4>Dibuat Oleh</h4>
        <dl class="row">
            <dt class="col-3">Nama</dt>
            <dd class="col-9">{{ $permintaan->user->name }}</dd>

            <dt class="col-3">Cabang</dt>
            <dd class="col-9">{{ $permintaan->user->cabang->nama_cabang ?? 'Pusat' }}</dd>

            <dt class="col-3">WhatsApp</dt>
            <dd class="col-9">
                @if ($permintaan->user->whatsapp_link)
                    <a href="{{ $permintaan->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                @else
                    -
                @endif
            </dd>
        </dl>

        <a href="{{ route('permintaan.index') }}" class="btn btn-link">&larr; Kembali</a>
    </div>
</div>
@endsection
