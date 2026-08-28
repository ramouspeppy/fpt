@extends('layouts.app')

@section('title', 'Detail Permintaan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2>{{ $permintaan->judul }}</h2>
                <span class="badge bg-azure-lt">{{ $permintaan->tipe }}</span>
                <span class="badge bg-{{ $permintaan->status == 'tersedia' ? 'green' : ($permintaan->status == 'matched' ? 'blue' : 'secondary') }}-lt">
                    {{ ucfirst($permintaan->status) }}
                </span>
                @if ($permintaan->prioritas_warna)
                    <span class="badge bg-{{ $permintaan->prioritas_warna == 'merah' ? 'red' : ($permintaan->prioritas_warna == 'kuning' ? 'yellow' : 'green') }}-lt">
                        Prioritas: {{ ucfirst($permintaan->prioritas_warna) }}
                    </span>
                @endif
            </div>
            @if (auth()->id() === $permintaan->user_id || auth()->user()->hasRole('Admin'))
                <a href="{{ route('permintaan.edit', $permintaan) }}" class="btn btn-outline-secondary">Edit</a>
            @endif
        </div>

        @if ($permintaan->prioritas_tag)
            <div class="alert alert-warning">{{ $permintaan->prioritas_tag }}</div>
        @endif

        <dl class="row">
            <dt class="col-3">Jenis Ikan</dt>
            <dd class="col-9">{{ $permintaan->jenis_ikan }}</dd>

            <dt class="col-3">Keterangan</dt>
            <dd class="col-9">{{ $permintaan->keterangan ?? '-' }}</dd>
        </dl>

        <hr>
        <h4>Rincian Grade / Size Dibutuhkan</h4>
        <div class="table-responsive mb-3">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Ukuran / Grade</th>
                        <th>Harga per kg</th>
                        <th>Kuantiti Dibutuhkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permintaan->rincianGrade as $rincian)
                        <tr>
                            <td>{{ $rincian->ukuran_grade }}</td>
                            <td>Rp {{ number_format($rincian->harga, 0) }}</td>
                            <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td>{{ $permintaan->rentang_harga }}</td>
                        <td>{{ number_format($permintaan->total_volume, 0) }} kg</td>
                    </tr>
                </tfoot>
            </table>
        </div>

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
                        <i class="ti ti-brand-whatsapp"></i> Hubungi via WhatsApp
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
