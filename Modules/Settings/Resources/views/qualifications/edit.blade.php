@extends('layouts.admin')
@section('title')  {{ __('qualifications') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('qualifications'), 'url' => url('/qualifications')],
['name' => __('edit').' '.__('qualifications'), 'active' => true],
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
                    {!! Form::model($qualification, ['method'=>'put','route'=>['qualifications.update',$qualification->id],'files'=>'true'])!!}
                    @include('settings::qualifications.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
