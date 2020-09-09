@extends('layouts.admin')
@section('title') {{ __('parent jobs') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('parent jobs'), 'url' => url('/parent-jobs')],
['name' => __('add').' '.__('parent jobs'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('add') }}</h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['method'=>'post','route'=>'parent-jobs.store'])!!}
                    @include('settings::parent_jobs.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
