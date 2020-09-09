@extends('layouts.admin')
@section('title') 
{{ __('academic years') }} 
@endsection 

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('academic years'), 'active' => true], 
];
@endphp

@include('layouts.breadcrumb', ['links' => $links])

<div class="card">
    @permission('academic-years_create')
    <div class="card-header w3-border-bottom w3-border-light-gray"  >
        <a href="{{route('academic-years.create')}}" class="btn btn-social btn-relief-primary">
            <i class="fa fa-plus"></i> {{ __('add') }}
        </a> 
    </div>
    @endpermission
    <div class="card-body">
        <div class="table-responsive">
            @include('settings::academic_years.table')
        </div>
    </div>
</div>

@endsection

