@extends('layouts.admin')
@section('title') {{ __('student_code_series') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('student code series'), 'url' => url('/student-code-series')],
['name' => __('edit').' '.__('student code series'), 'active' => true],
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
                    {!! Form::model($resource, ['method'=>'put','route'=>['student-code-series.update', $resource->id],'files'=>'true'])!!}
                    @include('settings::student_code_series.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> {{ __('save') }} </button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
