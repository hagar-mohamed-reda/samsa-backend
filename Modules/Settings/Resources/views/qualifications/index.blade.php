@extends('layouts.admin')
@section('title')  {{ __('qualifications') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('qualifications'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

     <div class="card">
        <div class="card-header">
            @permission('qualifications_create')
            <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('qualifications.create')}}"><i class="ik ik-plus-circle"></i>{{ __('create') }}</a>
            @endpermission
        </div>
        <div class="card-content">
            @include('includes.alerts.success')
            @include('includes.alerts.errors')
            <div class="table-responsive">
                @include('settings::qualifications.table')
            </div>
        </div>
    </div>
@endsection
