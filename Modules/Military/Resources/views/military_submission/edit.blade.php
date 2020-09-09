@extends('layouts.admin')
@section('title') {{ __('military area submission') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('military area submission'), 'url' => url('/military-area-submission')],
['name' => __('edit').' '.__('military area submission'), 'active' => true],
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
                    {!! Form::model($status, ['method'=>'put','route'=>['military-area-submission.update',$status->id],'files'=>'true'])!!}
                    @include('military::military_submission.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
