@extends('layouts.admin')
@section('title') {{ __('military areas') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('military status reason'), 'url' => url('/military-status-reason')],
['name' => __('edit').' '.__('military status reason'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('edit') }} </h3>
                </div>
                <div class="card-body">
                    {!! Form::model($resource, ['method'=>'put','route'=>['military-status-reason.update',$resource->id],'files'=>'true'])!!}
                    @include('military::military_status_reason.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
