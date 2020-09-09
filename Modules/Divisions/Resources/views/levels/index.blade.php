@extends('layouts.admin')
@section('title') {{ __('levels') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('levels'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

     <div class="card">
        @permission('levels_create')
        <div class="card-header">
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('levels.create')}}"><i class="ik ik-plus-circle"></i> {{ __('create') }} </a>
        </div>
        @endpermission
        <div class="card-content">

            <div class="table-responsive">
                @include('divisions::levels.table')
            </div>
        </div>
    </div>
@endsection
