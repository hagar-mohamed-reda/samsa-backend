@extends('layouts.admin')
@section('title') {{ __('required_documents') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('required_documents'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
     <div class="card">
        <div class="card-header">
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('required_documents.create')}}"><i class="fa fa-plus"></i>{{ __('create') }}</a>
        </div>
        <div class="card-content">

            <div class="table-responsive">
                @include('adminsion::required_documents.table')
            </div>
        </div>
    </div>
@endsection
