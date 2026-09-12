@extends('layouts.app')

@section('title', 'Tambah Komoditi')

@section('content')
<div class="row">
    <div class="col-md-7 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Komoditi</h4>
            </div>
            <div class="card-body">
                @include('komoditi._form')
            </div>
        </div>
    </div>
</div>
@endsection
