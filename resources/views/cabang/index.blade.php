@extends('layouts.app')

@section('title', 'Data Cabang')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('cabang.create') }}" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Cabang</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Nama Cabang</th>
                    <th>Lokasi</th>
                    <th>Region</th>
                    <th>Jumlah User</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cabang as $item)
                    <tr>
                        <td>{{ $item->nama_cabang }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->region ?? '-' }}</td>
                        <td>{{ $item->users_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('cabang.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form method="POST" action="{{ route('cabang.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Yakin hapus cabang ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $cabang->links() }}</div>
@endsection
