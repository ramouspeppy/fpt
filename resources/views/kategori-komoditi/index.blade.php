@extends('layouts.app')

@section('title', 'Kategori Komoditi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Kategori</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Jumlah Komoditi</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoriList as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->komoditi_count }}</td>
                                    <td class="text-right">
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
                                    <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Kategori Baru</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Kategori ini taksonomi besar (mis. Ikan, Udang, Kepiting, Cumi & Gurita) - hanya
                    Admin/Pusat yang bisa menambah, tanpa perlu approval.
                </div>
                <form method="POST" action="{{ route('kategoriKomoditi.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="mis. Cumi & Gurita">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah Kategori</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
