@extends('layouts.app')

@section('title', 'Detail Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2>{{ $penawaran->judul }}</h2>
                <span class="badge bg-azure-lt">{{ $penawaran->tipe }}</span>
                <span class="badge bg-purple-lt">{{ $penawaran->jenis_penawaran }}</span>
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
            <dd class="col-9">{{ $penawaran->komoditi->nama ?? '-' }} <span class="text-muted small">({{ $penawaran->komoditi->kategori ?? '-' }})</span></dd>

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
                        <th>Harga Beli / kg</th>
                        <th>Kuantiti</th>
                        <th>Harga Jual / kg</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penawaran->rincianGrade as $rincian)
                        <tr>
                            <td>{{ $rincian->ukuran_grade }}</td>
                            <td>Rp {{ number_format($rincian->harga, 0) }}</td>
                            <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                            <td class="fw-bold">Rp {{ number_format($rincian->harga_jual, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td>-</td>
                        <td>{{ number_format($penawaran->total_volume, 0) }} kg</td>
                        <td>{{ $penawaran->rentang_harga }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h4>{{ $penawaran->isTrading() ? 'Margin / Keuntungan' : 'Rincian Biaya HPP' }}</h4>
        <div class="text-muted small mb-2">
            @if ($penawaran->isTrading())
                Barang sudah jadi dari mitra, biaya di bawah ini murni margin/keuntungan.
            @else
                Biaya operasional per kg, berlaku sama untuk semua grade di atas.
            @endif
        </div>
        <div class="table-responsive mb-3">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Komponen Biaya</th>
                        <th>Rp / kg</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penawaran->biayaHpp as $biaya)
                        <tr>
                            <td>{{ $biaya->label }}</td>
                            <td>Rp {{ number_format($biaya->jumlah, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td>Total Biaya Tambahan</td>
                        <td>Rp {{ number_format($penawaran->total_biaya_tambahan, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if (auth()->id() === $penawaran->user_id || auth()->user()->hasRole('Admin'))
            <hr>
            <h4>Ubah Status</h4>
            <div class="text-muted small mb-2">
                Status ini murni penanda kondisi nyata di lapangan — tidak diubah otomatis oleh sistem,
                jadi silakan update sendiri sesuai perkembangan komunikasi dengan pihak yang match.
            </div>
            <div class="btn-group" role="group">
                @foreach (['tersedia' => 'Tersedia', 'matched' => 'Sedang Diproses', 'selesai' => 'Selesai', 'ditutup' => 'Tutup'] as $nilai => $label)
                    <form method="POST" action="{{ route('penawaran.updateStatus', $penawaran) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nilai }}">
                        <button type="submit" class="btn btn-sm {{ $penawaran->status === $nilai ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $label }}
                        </button>
                    </form>
                @endforeach
            </div>
        @endif

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
