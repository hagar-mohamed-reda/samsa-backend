@extends('layouts.admin')
@section('title') 
{{ __('users') }} 
@endsection 

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('users'), 'active' => true], 
];
@endphp

@include('layouts.breadcrumb', ['links' => $links])

<div class="card">
    @permission('users_create')
    <div class="card-header w3-border-bottom w3-border-light-gray"  > 
        <a href="{{route('users.create')}}" class="btn btn-social btn-relief-primary">
            <i class="fa fa-plus"></i> {{ __('add') }}
        </a>  
    </div>
    @endpermission
    <div class="card-body">
        <div class="table-responsive">
            @include('settings::users.table')
        </div>
    </div>
</div>

@endsection

