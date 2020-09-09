@extends('layouts.admin')
@section('title') {{ __('submissions status') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('submission status'), 'url' => url('/registeration-status')],
['name' => __('edit').' '.__('submission status'), 'active' => true],
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
                    {!! Form::model($registerationStatus, ['method'=>'put','route'=>['registeration-status.update',$registerationStatus->id],'files'=>'true'])!!}
                    @include('settings::registeration_status.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
