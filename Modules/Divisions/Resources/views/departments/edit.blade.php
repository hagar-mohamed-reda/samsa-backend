@extends('layouts.admin')
@section('title') {{ __('departments') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('departments'), 'url' => url('/departments')],
['name' => __('edit').' '.__('departments'), 'active' => true],
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
                    {!! Form::model($department, ['method'=>'put','route'=>['departments.update',$department->id],'files'=>'true'])!!}
                    @include('divisions::departments.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
