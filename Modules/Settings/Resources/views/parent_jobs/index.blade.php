@extends('layouts.admin')
@section('title') {{ __('parent jobs') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('parent jobs'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
     <div class="card">
        <div class="card-header">
            @permission('parent-jobs_create')
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('parent-jobs.create')}}"><i class="ik ik-plus-circle"></i> {{ __('create') }}</a>
            @endpermission
        </div>
        <div class="card-content">
            <div class="table-responsive">
                @include('settings::parent_jobs.table')
            </div>
        </div>
    </div>
@endsection
