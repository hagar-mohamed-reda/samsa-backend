@extends('layouts.admin')
@section('title') {{ __('applications') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('applications'), 'url' => url('/applications')],
['name' => __('edit application'), 'active' => true],
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
                    {!! Form::model($application, ['method'=>'put', 'class' => 'form', 'route'=>['applications.update',$application->id],'files'=>'true'])!!}
                    @include('adminsion::applications.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
