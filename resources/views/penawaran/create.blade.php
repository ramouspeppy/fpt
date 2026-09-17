@extends('layouts.app')

@section('title', 'Tambah Penawaran')

@section('content')
    <div class="card" id="card-data">
        <div class="card-body">
            @include('penawaran._form')
        </div>
    </div>
@endsection
