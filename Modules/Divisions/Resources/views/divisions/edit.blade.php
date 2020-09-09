@extends('layouts.admin')
@section('title') {{ __('divisions') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('divisions'), 'url' => url('/divisions')],
['name' => __('edit').' '.__('divisions'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('edit') }}</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($devision, ['method'=>'put','route'=>['divisions.update',$devision->id],'files'=>'true'])!!}
                    @include('divisions::divisions.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
