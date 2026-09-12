@extends('layouts.app')

@section('title', 'Tambah Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        @include('penawaran._form')
    </div>
</div>
@endsection
