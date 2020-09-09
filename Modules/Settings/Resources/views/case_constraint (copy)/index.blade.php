@extends('layouts.admin')
@section('title') {{ __('case constraint') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('case constraint'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
     <div class="card">
        <div class="card-header">
            @permission('parent-jobs_create')
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('case-constraint.create')}}"><i class="ik ik-plus-circle"></i> {{ __('create') }}</a>
            @endpermission
        </div>
        <div class="card-content">
            <div class="table-responsive">
                @include('settings::case_constraint.table')
            </div>
        </div>
    </div>
@endsection
