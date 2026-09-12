@extends('layouts.app')

@section('title', 'Edit Cabang')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Cabang</h4>
            </div>
            <div class="card-body">
                @include('cabang._form')
            </div>
        </div>
    </div>
</div>
@endsection
