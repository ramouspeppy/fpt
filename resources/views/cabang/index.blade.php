@extends('layouts.app')

@section('title', 'Data Cabang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Cabang</h4>
                @role('Admin')
                    <div class="card-header-action">
                        <a href="{{ route('cabang.create') }}" class="btn btn-info">
                            <i class="fas fa-plus"></i> Tambah Cabang
                        </a>
                    </div>
                @endrole
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Cabang</th>
                                <th>Lokasi</th>
                                <th>Region</th>
                                <th>Jumlah User</th>
                                @role('Admin')
                                    <th class="text-right">Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cabang as $item)
                                <tr>
                                    <td>{{ $item->nama_cabang }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->region ?? '-' }}</td>
                                    <td>{{ $item->users_count }}</td>
                                    @role('Admin')
                                        <td class="text-right">
                                            <a href="{{ route('cabang.edit', $item) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('cabang.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Yakin hapus cabang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                            </form>
                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $cabang->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
