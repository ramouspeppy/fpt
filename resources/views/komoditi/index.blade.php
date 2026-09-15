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
            @if ($bolehKelola)
                <a href="{{ route('kategoriKomoditi.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-tags"></i> Kelola Kategori
                </a>
                <a href="{{ route('komoditi.create') }}" class="btn btn-info">
                    <i class="fas fa-plus"></i> Tambah Komoditi
                </a>
            @else
                <a href="{{ route('komoditi.usulkan') }}" class="btn btn-info">
                    <i class="fas fa-plus"></i> Usulkan Komoditi
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Daftar Komoditi</h4>
            @if ($bolehKelola)
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
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 6%"></th>
                            <th class="pl-4" style="width: 20%">Nama Komoditi</th>
                            <th style="width: 12%">Kategori</th>
                            <th style="width: 24%">Juga Dikenal Sebagai</th>
                            <th style="width: 12%">Status</th>
                            <th style="width: 12%">Diusulkan Oleh</th>
                            <th class="text-right pr-4" style="width: 14%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($komoditi as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->fotoUtama())
                                        <img src="{{ $item->fotoUtama()->getUrl('thumb') }}" alt="{{ $item->nama }}"
                                            class="rounded border" style="width: 36px; height: 36px; object-fit: cover;">
                                    @else
                                        <span class="text-muted"><i class="fas fa-image"></i></span>
                                    @endif
                                </td>
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
                                        @if ($bolehKelola)
                                            <a href="{{ route('komoditi.edit', $item) }}" class="btn btn-sm btn-icon icon-left btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('komoditi.size.index', $item) }}" class="btn btn-sm btn-icon icon-left btn-info" title="Kelola Size">
                                                <i class="fas fa-ruler"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('komoditi.tag.index', $item) }}" class="btn btn-sm btn-icon icon-left btn-secondary" title="Kelola Nama Ikan Lainnya">
                                            <i class="fas fa-tag"></i>
                                        </a>
                                    @endif
                                    @if ($bolehKelola && $item->status === 'menunggu_approval')
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
                                <td colspan="7" class="text-center text-muted py-4">Belum ada komoditi.</td>
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
