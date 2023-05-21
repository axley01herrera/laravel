@extends('error.header')
@section('title')
    Error
@endsection
@section('content')
    <div class="bg-overlay bg-white"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center py-5">
                    <h1 class="display-1 fw-normal error-text">ERROR</h1>
                    <h4 class="text-uppercase text-muted">{{ $msg }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection