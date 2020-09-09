@extends('layouts.admin')
@section('title') {{ __('constraint status') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('constraint status'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
     <div class="card">
        <div class="card-header">
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('constraint-status.create')}}"><i class="ik ik-plus-circle"></i> {{ __('create') }}</a>
        </div>
        <div class="card-content">
            <div class="table-responsive">
                @include('settings::constraint_status.table')
            </div>
        </div>
    </div>
@endsection

