@extends('layouts.admin')
@section('title') {{ __('military course') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('military course'), 'url' => url('/military-course')],
['name' => __('edit').' '.__('military course'), 'active' => true],
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
                    {!! Form::model($row, ['method'=>'put','route'=>['military-course.update',$row->id],'files'=>'true'])!!}
                    @include('military::military_course.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> {{ __('save') }} </button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
