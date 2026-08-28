@extends('layouts.app')

@section('title', 'Detail Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2>{{ $penawaran->judul }}</h2>
                <span class="badge bg-azure-lt">{{ $penawaran->tipe }}</span>
                <span class="badge bg-{{ $penawaran->status == 'tersedia' ? 'green' : ($penawaran->status == 'matched' ? 'blue' : 'secondary') }}-lt">
                    {{ ucfirst($penawaran->status) }}
                </span>
            </div>
            @if (auth()->id() === $penawaran->user_id || auth()->user()->hasRole('Admin'))
                <a href="{{ route('penawaran.edit', $penawaran) }}" class="btn btn-outline-secondary">Edit</a>
            @endif
        </div>

        <dl class="row">
            <dt class="col-3">Jenis Ikan</dt>
            <dd class="col-9">{{ $penawaran->jenis_ikan }}</dd>

            <dt class="col-3">Kondisi Ikan</dt>
            <dd class="col-9">{{ $penawaran->kondisi_ikan ?? '-' }}</dd>

            <dt class="col-3">Keterangan</dt>
            <dd class="col-9">{{ $penawaran->keterangan ?? '-' }}</dd>
        </dl>

        <hr>
        <h4>Rincian Grade / Size</h4>
        <div class="table-responsive mb-3">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Ukuran / Grade</th>
                        <th>Harga per kg</th>
                        <th>Kuantiti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penawaran->rincianGrade as $rincian)
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
                        <td>{{ $penawaran->rentang_harga }}</td>
                        <td>{{ number_format($penawaran->total_volume, 0) }} kg</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ($penawaran->detailEkspor)
            <hr>
            <h4>Detail Ekspor</h4>
            <dl class="row">
                <dt class="col-3">Sertifikasi</dt>
                <dd class="col-9">{{ $penawaran->detailEkspor->sertifikasi ?? '-' }}</dd>

                <dt class="col-3">Kontinuitas Suplai</dt>
                <dd class="col-9">{{ $penawaran->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>

                <dt class="col-3">Negara Tujuan</dt>
                <dd class="col-9">{{ $penawaran->detailEkspor->negara_tujuan ?? '-' }}</dd>
            </dl>
        @endif

        <hr>
        <h4>Dibuat Oleh</h4>
        <dl class="row">
            <dt class="col-3">Nama</dt>
            <dd class="col-9">{{ $penawaran->user->name }}</dd>

            <dt class="col-3">Cabang</dt>
            <dd class="col-9">{{ $penawaran->user->cabang->nama_cabang ?? '-' }} ({{ $penawaran->user->cabang->lokasi ?? '-' }})</dd>

            <dt class="col-3">WhatsApp</dt>
            <dd class="col-9">
                @if ($penawaran->user->whatsapp_link)
                    <a href="{{ $penawaran->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                        <i class="ti ti-brand-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                @else
                    -
                @endif
            </dd>
        </dl>

        <a href="{{ route('penawaran.index') }}" class="btn btn-link">&larr; Kembali</a>
    </div>
</div>
@endsection
