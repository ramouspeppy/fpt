@extends('layouts.app')

@section('title', 'Kategori Komoditi')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div class="mb-2">
            <h2 class="mb-0">Kategori Komoditi</h2>
            <div class="text-muted">Taksonomi besar untuk mengelompokkan komoditi, mis. Ikan, Udang, Kepiting</div>
        </div>
        <div class="mb-2">
            <a href="{{ route('komoditi.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Komoditi
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahKategori">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th class="pl-4">Nama Kategori</th>
                            <th>Jumlah Komoditi</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoriList as $item)
                            <tr>
                                <td class="pl-4 font-weight-bold">{{ $item->nama }}</td>
                                <td>
                                    <span class="badge badge-light border">{{ $item->komoditi_count }} komoditi</span>
                                </td>
                                <td class="text-right pr-4">
                                    @if ($item->komoditi_count === 0)
                                        <form method="POST" action="{{ route('kategoriKomoditi.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Masih dipakai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('kategoriKomoditi.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-muted small mb-3">
                            Kategori ini taksonomi besar - hanya Admin/Pusat yang bisa menambah, tanpa perlu approval.
                        </div>
                        <div class="form-group mb-0">
                            <label>Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="mis. Cumi & Gurita">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any() && old('nama'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#modalTambahKategori').modal('show');
            });
        </script>
    @endif
@endpush
