@extends('layouts.app')

@section('title', 'Detail Project #' . $project->id)

@section('content')
@php
    $labelStatus = ['sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
    $warnaStatus = ['sedang_diproses' => 'primary', 'selesai' => 'success', 'tutup' => 'secondary'];
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="mb-0">Project #{{ $project->id }}</h3>
                    <span class="badge badge-{{ $warnaStatus[$project->status] ?? 'secondary' }}">
                        {{ $labelStatus[$project->status] ?? ucfirst($project->status) }}
                    </span>
                </div>

                <div class="text-muted small mb-3">
                    Dipilih oleh <strong>{{ $project->pemilih->name ?? '-' }}</strong>
                    pada {{ $project->created_at->translatedFormat('d M Y, H:i') }}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body bg-light mb-3">
                            <div class="text-muted small font-weight-bold mb-1">PENAWARAN</div>
                            <a href="{{ route('penawaran.show', $project->penawaran) }}"><strong>{{ $project->penawaran->judul }}</strong></a>
                            <div class="small text-muted mb-2">
                                {{ $project->penawaran->komoditi->nama ?? '-' }} &middot;
                                {{ $project->penawaran->user->cabang->nama_cabang ?? '-' }}
                            </div>
                            <div class="small">
                                Dibuat oleh: {{ $project->penawaran->user->name }}<br>
                                @if ($project->penawaran->user->whatsapp_link)
                                    <a href="{{ $project->penawaran->user->whatsapp_link }}" target="_blank" class="text-success">
                                        <i class="fab fa-whatsapp"></i> {{ $project->penawaran->user->no_whatsapp }}
                                    </a>
                                @endif
                            </div>
                            <ul class="list-unstyled small mt-2 mb-0">
                                @foreach ($project->penawaran->rincianSize as $rincian)
                                    <li>{{ $rincian->komoditiSize->nama_size ?? '-' }}: Rp {{ number_format($rincian->harga_jual, 0) }}/kg &middot; {{ number_format($rincian->kuantiti, 0) }} kg</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body bg-light mb-3">
                            <div class="text-muted small font-weight-bold mb-1">PERMINTAAN</div>
                            <a href="{{ route('permintaan.show', $project->permintaan) }}"><strong>{{ $project->permintaan->judul }}</strong></a>
                            <div class="small text-muted mb-2">
                                {{ $project->permintaan->komoditi->nama ?? '-' }} &middot;
                                {{ $project->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}
                            </div>
                            <div class="small">
                                Dibuat oleh: {{ $project->permintaan->user->name }}<br>
                                @if ($project->permintaan->user->whatsapp_link)
                                    <a href="{{ $project->permintaan->user->whatsapp_link }}" target="_blank" class="text-success">
                                        <i class="fab fa-whatsapp"></i> {{ $project->permintaan->user->no_whatsapp }}
                                    </a>
                                @endif
                            </div>
                            <ul class="list-unstyled small mt-2 mb-0">
                                @foreach ($project->permintaan->rincianSize as $rincian)
                                    <li>{{ $rincian->komoditiSize->nama_size ?? '-' }}: Rp {{ number_format($rincian->harga, 0) }}/kg &middot; {{ number_format($rincian->kuantiti, 0) }} kg</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                @if ($project->status !== 'tutup')
                    <hr>
                    <h4>Ubah Status</h4>
                    <div class="text-muted small mb-2">
                        Kalau ditutup, Anda WAJIB mengisi catatan alasan penutupan.
                    </div>
                    <div class="btn-group mb-2" role="group">
                        <form method="POST" action="{{ route('project.updateStatus', $project) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="sedang_diproses">
                            <button type="submit" class="btn btn-sm {{ $project->status === 'sedang_diproses' ? 'btn-primary' : 'btn-secondary' }}">Sedang Diproses</button>
                        </form>
                        <form method="POST" action="{{ route('project.updateStatus', $project) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-sm {{ $project->status === 'selesai' ? 'btn-primary' : 'btn-secondary' }}">Selesai</button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTutupProject">Tutup Project</button>
                    </div>

                    @error('catatan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <!-- Modal Tutup Project - catatan alasan WAJIB diisi -->
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
                @else
                    <hr>
                    <div class="alert alert-secondary">
                        <i class="fas fa-lock"></i> Project ini sudah ditutup, status tidak bisa diubah lagi.
                    </div>
                @endif

                <a href="{{ route('project.index') }}" class="btn btn-link">&larr; Kembali ke daftar Project</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Catatan / Progress</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Bisa diisi oleh kedua pihak (Penawaran & Permintaan) maupun Pusat/Admin.
                    Catatan bersifat permanen — kalau ada koreksi, tambahkan catatan baru.
                </div>

                <form method="POST" action="{{ route('project.storeCatatan', $project) }}" class="mb-3">
                    @csrf
                    <div class="form-group">
                        <textarea name="isi_catatan" class="form-control @error('isi_catatan') is-invalid @enderror" rows="3" placeholder="Tulis update progress di sini..." required>{{ old('isi_catatan') }}</textarea>
                        @error('isi_catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-block">Tambah Catatan</button>
                </form>

                <hr>

                <div style="max-height: 500px; overflow-y: auto;">
                    @forelse ($project->catatan as $catatan)
                        <div class="mb-3 pb-2 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong class="small">{{ $catatan->user->name ?? '-' }}</strong>
                                <span class="text-muted small">{{ $catatan->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <div class="small" style="white-space: pre-line;">{{ $catatan->isi_catatan }}</div>
                        </div>
                    @empty
                        <div class="text-muted small">Belum ada catatan.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
