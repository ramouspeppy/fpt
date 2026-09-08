@extends('layouts.app')

@section('title', 'Project #' . $project->id)

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></div>
    <div class="breadcrumb-item">#{{ $project->id }}</div>
@endsection

@section('content')
    @php
        $labelStatus = ['sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
        $warnaStatus = ['sedang_diproses' => 'primary', 'selesai' => 'success', 'tutup' => 'secondary'];
        $ikonStatus = ['sedang_diproses' => 'fa-sync-alt', 'selesai' => 'fa-check-circle', 'tutup' => 'fa-lock'];
        $warnaStatusPosting = ['tersedia' => 'success', 'sedang_diproses' => 'primary', 'selesai' => 'dark', 'tutup' => 'secondary'];
        $labelStatusPosting = ['tersedia' => 'Tersedia', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
        $warnaPrioritas = ['merah' => 'danger', 'kuning' => 'warning', 'hijau' => 'success'];
    @endphp

    <div class="section-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <span class="badge badge-{{ $warnaStatus[$project->status] ?? 'secondary' }} p-2">
                <i class="fas {{ $ikonStatus[$project->status] ?? 'fa-info-circle' }}"></i>
                {{ $labelStatus[$project->status] ?? ucfirst($project->status) }}
            </span>
            <div class="text-muted small">
                Dipilih oleh <strong>{{ $project->pemilih->name ?? '-' }}</strong>
                pada {{ $project->created_at->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        <div class="row">
            <!-- PENAWARAN - kartu lengkap -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-fish"></i> Penawaran</h4>
                        <div class="card-header-action">
                            <span class="badge badge-{{ $warnaStatusPosting[$project->penawaran->status] ?? 'secondary' }}">
                                {{ $labelStatusPosting[$project->penawaran->status] ?? ucfirst($project->penawaran->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('penawaran.show', $project->penawaran) }}">{{ $project->penawaran->judul }}</a></h5>
                        <div class="mb-3">
                            <span class="badge badge-info">{{ $project->penawaran->tipe }}</span>
                            <span class="badge badge-purple">{{ $project->penawaran->jenis_penawaran }}</span>
                        </div>

                        <dl class="row small mb-3">
                            <dt class="col-5">Komoditi</dt>
                            <dd class="col-7">{{ $project->penawaran->komoditi->nama ?? '-' }}</dd>

                            <dt class="col-5">Kondisi Ikan</dt>
                            <dd class="col-7">{{ $project->penawaran->kondisi_ikan ?? '-' }}</dd>

                            <dt class="col-5">Cabang</dt>
                            <dd class="col-7">{{ $project->penawaran->user->cabang->nama_cabang ?? '-' }}</dd>

                            <dt class="col-5">Dibuat Oleh</dt>
                            <dd class="col-7">{{ $project->penawaran->user->name }}</dd>
                        </dl>

                        @if ($project->penawaran->keterangan)
                            <div class="text-muted small mb-3">{{ $project->penawaran->keterangan }}</div>
                        @endif

                        <h6>Rincian Size</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Harga Jual/kg</th>
                                        <th>Kuantiti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->penawaran->rincianSize as $rincian)
                                        <tr>
                                            <td>{{ $rincian->komoditiSize->nama_size ?? '-' }}</td>
                                            <td>Rp {{ number_format($rincian->harga_jual, 0) }}</td>
                                            <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($project->penawaran->detailEkspor)
                            <h6>Detail Ekspor</h6>
                            <dl class="row small mb-3">
                                <dt class="col-5">Sertifikasi</dt>
                                <dd class="col-7">{{ $project->penawaran->detailEkspor->sertifikasi ?? '-' }}</dd>
                                <dt class="col-5">Kontinuitas Suplai</dt>
                                <dd class="col-7">{{ $project->penawaran->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>
                                <dt class="col-5">Negara Tujuan</dt>
                                <dd class="col-7">{{ $project->penawaran->detailEkspor->negara_tujuan ?? '-' }}</dd>
                            </dl>
                        @endif

                        @if ($project->penawaran->user->whatsapp_link)
                            <a href="{{ $project->penawaran->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fab fa-whatsapp"></i> Hubungi {{ $project->penawaran->user->name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- PERMINTAAN - kartu lengkap -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-clipboard-list"></i> Permintaan</h4>
                        <div class="card-header-action">
                            <span class="badge badge-{{ $warnaStatusPosting[$project->permintaan->status] ?? 'secondary' }}">
                                {{ $labelStatusPosting[$project->permintaan->status] ?? ucfirst($project->permintaan->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('permintaan.show', $project->permintaan) }}">{{ $project->permintaan->judul }}</a></h5>
                        <div class="mb-3">
                            <span class="badge badge-info">{{ $project->permintaan->tipe }}</span>
                            @if ($project->permintaan->prioritas_warna)
                                <span class="badge badge-{{ $warnaPrioritas[$project->permintaan->prioritas_warna] ?? 'secondary' }}">
                                    Prioritas: {{ ucfirst($project->permintaan->prioritas_warna) }}
                                </span>
                            @endif
                        </div>

                        @if ($project->permintaan->prioritas_tag)
                            <div class="alert alert-warning py-2 px-3">{{ $project->permintaan->prioritas_tag }}</div>
                        @endif

                        <dl class="row small mb-3">
                            <dt class="col-5">Komoditi</dt>
                            <dd class="col-7">{{ $project->permintaan->komoditi->nama ?? '-' }}</dd>

                            <dt class="col-5">Cabang / Buyer</dt>
                            <dd class="col-7">{{ $project->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}</dd>

                            <dt class="col-5">Dibuat Oleh</dt>
                            <dd class="col-7">{{ $project->permintaan->user->name }}</dd>
                        </dl>

                        @if ($project->permintaan->keterangan)
                            <div class="text-muted small mb-3">{{ $project->permintaan->keterangan }}</div>
                        @endif

                        <h6>Rincian Size</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Harga/kg</th>
                                        <th>Kuantiti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->permintaan->rincianSize as $rincian)
                                        <tr>
                                            <td>{{ $rincian->komoditiSize->nama_size ?? '-' }}</td>
                                            <td>Rp {{ number_format($rincian->harga, 0) }}</td>
                                            <td>{{ number_format($rincian->kuantiti, 0) }} kg</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($project->permintaan->detailEkspor)
                            <h6>Detail Ekspor</h6>
                            <dl class="row small mb-3">
                                <dt class="col-5">Sertifikasi</dt>
                                <dd class="col-7">{{ $project->permintaan->detailEkspor->sertifikasi ?? '-' }}</dd>
                                <dt class="col-5">Kontinuitas Suplai</dt>
                                <dd class="col-7">{{ $project->permintaan->detailEkspor->kontinuitas_suplai ?? '-' }}</dd>
                                <dt class="col-5">Negara Tujuan</dt>
                                <dd class="col-7">{{ $project->permintaan->detailEkspor->negara_tujuan ?? '-' }}</dd>
                            </dl>
                        @endif

                        @if ($project->permintaan->user->whatsapp_link)
                            <a href="{{ $project->permintaan->user->whatsapp_link }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fab fa-whatsapp"></i> Hubungi {{ $project->permintaan->user->name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($project->status !== 'tutup')
            <div class="card">
                <div class="card-body">
                    <h5>Ubah Status</h5>
                    <div class="text-muted small mb-2">
                        Kalau ditutup, Anda WAJIB mengisi catatan alasan penutupan.
                    </div>
                    <div class="btn-group mb-2" role="group">
                        <form method="POST" action="{{ route('project.updateStatus', $project) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="sedang_diproses">
                            <button type="submit" class="btn btn-sm {{ $project->status === 'sedang_diproses' ? 'btn-primary' : 'btn-secondary' }}">
                                <i class="fas fa-sync-alt"></i> Sedang Diproses
                            </button>
                        </form>
                        <form method="POST" action="{{ route('project.updateStatus', $project) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-sm {{ $project->status === 'selesai' ? 'btn-primary' : 'btn-secondary' }}">
                                <i class="fas fa-check-circle"></i> Selesai
                            </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTutupProject">
                            <i class="fas fa-lock"></i> Tutup Project
                        </button>
                    </div>

                    @error('catatan')
                        <div class="alert alert-danger mb-0">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @else
            <div class="alert alert-secondary">
                <i class="fas fa-lock"></i> Project ini sudah ditutup, status tidak bisa diubah lagi.
            </div>
        @endif

        <a href="{{ route('project.index') }}" class="btn btn-link">&larr; Kembali ke daftar Project</a>
    </div>

    <!-- Catatan / Progress - form tambah berdampingan dengan riwayatnya -->
    <div class="section-body">
        <h2 class="section-title">Catatan / Progress</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Catatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-muted small mb-3">
                            Bisa diisi oleh kedua pihak (Penawaran & Permintaan) maupun Pusat/Admin.
                            Catatan bersifat permanen — kalau ada koreksi, tambahkan catatan baru.
                        </div>

                        <form method="POST" action="{{ route('project.storeCatatan', $project) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="isi_catatan" class="form-control @error('isi_catatan') is-invalid @enderror" rows="4" placeholder="Tulis update progress di sini..." required>{{ old('isi_catatan') }}</textarea>
                                @error('isi_catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambah Catatan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @php
                    $catatanPerTanggal = $project->catatan->groupBy(fn($c) => $c->created_at->translatedFormat('d F Y'));
                @endphp

                @forelse ($catatanPerTanggal as $tanggal => $daftarCatatan)
                    <h5 class="text-muted mt-0 mb-2">{{ $tanggal }}</h5>
                    <div class="activities">
                        @foreach ($daftarCatatan as $catatan)
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary">{{ $catatan->created_at->diffForHumans() }}</span>
                                        <span class="bullet"></span>
                                        <span class="text-job">{{ $catatan->user->name ?? '-' }}</span>
                                    </div>
                                    <p style="white-space: pre-line;">{{ $catatan->isi_catatan }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="alert alert-info">Belum ada catatan untuk project ini.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Tutup Project - catatan alasan WAJIB diisi -->
    @if ($project->status !== 'tutup')
        @push('scripts')
            <div class="modal fade" id="modalTutupProject" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form method="POST" action="{{ route('project.updateStatus', $project) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="tutup">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tutup Project</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small">Project yang ditutup tidak bisa diubah statusnya lagi. Jelaskan alasan penutupan (mis. nego gagal, barang tidak jadi dikirim, dll) — catatan ini akan tersimpan permanen di riwayat project.</p>
                                <div class="form-group">
                                    <label>Alasan Penutupan <span class="text-danger">*</span></label>
                                    <textarea name="catatan" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tutup Project</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endpush
    @endif
@endsection
