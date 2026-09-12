@extends('layouts.app')

@section('title', 'Edit Permintaan')

@section('content')
<div class="card">
    <div class="card-body">
        @include('permintaan._form')
    </div>
</div>
@endsection
