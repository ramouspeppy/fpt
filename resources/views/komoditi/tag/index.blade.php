@extends('layouts.app')

@section('title', 'Nama Daerah - ' . $komoditi->nama)

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4>{{ $komoditi->nama }}</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    {{ $komoditi->kategoriKomoditi->nama ?? '-' }} &middot;
                    Nama daerah/alias di bawah ini membantu pencarian - siapapun yang tahu nama lain
                    untuk komoditi ini di daerahnya boleh menambahkan.
                </div>

                @if ($komoditi->tags->isEmpty())
                    <div class="alert alert-info">Belum ada nama daerah untuk komoditi ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Daerah</th>
                                    <th>Ditambahkan Oleh</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($komoditi->tags as $tag)
                                    <tr>
                                        <td>{{ $tag->nama_tag }}</td>
                                        <td class="text-muted small">{{ $tag->penambah->name ?? '-' }}</td>
                                        <td class="text-right">
                                            <form method="POST" action="{{ route('komoditi.tag.destroy', [$komoditi, $tag]) }}" class="d-inline" onsubmit="return confirm('Hapus nama daerah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Nama Daerah</h4>
            </div>
            <div class="card-body">
                <div class="text-muted small mb-3">
                    Contoh: komoditi "Giant Trevally (GT)" di beberapa daerah dikenal sebagai
                    "Ikan Gabui" atau "Ikan Kuwe". Tulis nama itu di sini supaya orang lain yang
                    cari pakai istilah daerahnya tetap ketemu.
                </div>
                <form method="POST" action="{{ route('komoditi.tag.store', $komoditi) }}">
                    @csrf
                    <div class="form-group">
                        <label>Dikenal Juga Sebagai <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tag" value="{{ old('nama_tag') }}" class="form-control @error('nama_tag') is-invalid @enderror" placeholder="mis. Ikan Gabui">
                        @error('nama_tag') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
