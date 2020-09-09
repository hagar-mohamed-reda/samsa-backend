@extends('layouts.admin')
@section('title') {{ __('qualification types') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('qualification types'), 'url' => url('/qualification-types')],
['name' => __('edit').' '.__('qualification types'), 'active' => true],
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
                    {!! Form::model($qualification, ['method'=>'put','route'=>['qualification-types.update',$qualification->id],'files'=>'true'])!!}
                    @include('settings::qualification_types.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> {{ __('save') }} </button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
