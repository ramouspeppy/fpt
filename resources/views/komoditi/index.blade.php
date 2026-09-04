@extends('layouts.app')

@section('title', 'Master Data Komoditi')

@section('content')
    @php
        $warnaStatus = ['disetujui' => 'success', 'menunggu_approval' => 'warning', 'ditolak' => 'danger'];
        $paletKategori = ['primary', 'success', 'warning', 'info', 'purple', 'navy', 'maroon', 'lime', 'indigo', 'danger'];
    @endphp

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div class="mb-2">
            <h2 class="mb-0">Master Data Komoditi</h2>
            <div class="text-muted">{{ $komoditi->total() }} komoditi terdaftar</div>
        </div>
        <div class="mb-2">
            <a href="{{ route('kategoriKomoditi.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-tags"></i> Kelola Kategori
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahKomoditi">
                <i class="fas fa-plus"></i> Tambah Komoditi
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Daftar Komoditi</h4>
            <div class="card-header-form">
                <form method="GET">
                    <select name="status" class="form-control selectric" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu_approval" @selected(request('status') == 'menunggu_approval')>Menunggu Approval</option>
                        <option value="disetujui" @selected(request('status') == 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(request('status') == 'ditolak')>Ditolak</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th class="pl-4" style="width: 24%">Nama Komoditi</th>
                            <th style="width: 14%">Kategori</th>
                            <th style="width: 26%">Juga Dikenal Sebagai</th>
                            <th style="width: 12%">Status</th>
                            <th style="width: 12%">Diusulkan Oleh</th>
                            <th class="text-right pr-4" style="width: 12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($komoditi as $item)
                            <tr>
                                <td class="pl-4">
                                    <div class="font-weight-bold">{{ $item->nama }}</div>
                                </td>
                                <td>
                                    @if ($item->kategoriKomoditi)
                                        <span class="badge badge-{{ $paletKategori[$item->kategori_id % count($paletKategori)] }}">
                                            {{ $item->kategoriKomoditi->nama }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse ($item->tags as $tag)
                                        <span class="badge badge-light border mr-1 mb-1">{{ $tag->nama_tag }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }}">
                                        {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $item->pengusul->name ?? '-' }}</td>
                                <td class="text-right pr-4">
                                    @if ($item->status === 'disetujui')
                                        <a href="{{ route('komoditi.size.index', $item) }}" class="btn btn-sm btn-icon icon-left btn-info" title="Kelola Size">
                                            <i class="fas fa-ruler"></i>
                                        </a>
                                        <a href="{{ route('komoditi.tag.index', $item) }}" class="btn btn-sm btn-icon icon-left btn-secondary" title="Kelola Nama Daerah">
                                            <i class="fas fa-tag"></i>
                                        </a>
                                    @endif
                                    @if ($item->status === 'menunggu_approval')
                                        <form method="POST" action="{{ route('komoditi.approve', $item) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('komoditi.tolak', $item) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-danger">Tolak</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada komoditi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $komoditi->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Modal Tambah Komoditi -->
    <div class="modal fade" id="modalTambahKomoditi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('komoditi.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Komoditi Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-muted small mb-3">Input langsung oleh Admin/Pusat otomatis disetujui, tidak perlu approval.</div>
                        <div class="form-group">
                            <label>Nama Komoditi <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-control select2" data-placeholder="-- Pilih Kategori --">
                                <option value=""></option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Kategori belum ada di daftar? <a href="{{ route('kategoriKomoditi.index') }}">Tambah dulu di sini</a>.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah & Setujui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any() && old('nama'))
        <script>
            // Kalau validasi gagal saat submit dari modal, buka lagi modalnya otomatis
            document.addEventListener('DOMContentLoaded', function() {
                $('#modalTambahKomoditi').modal('show');
            });
        </script>
    @endif
@endpush
