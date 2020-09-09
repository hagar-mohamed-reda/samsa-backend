@extends('layouts.admin')
@section('title') {{ __('constraint status') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('parent jobs'), 'url' => url('/parent-jobs')],
['name' => __('edit').' '.__('constraint status'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3> {{ __('edit') }}</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($resource, ['method'=>'put','route'=>['constraint-status.update',$resource->id],'files'=>'true'])!!}
                    @include('settings::constraint_status.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
