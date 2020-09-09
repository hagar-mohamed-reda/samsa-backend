@extends('layouts.admin')
@section('title') {{ __('academic years') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('academic year'), 'url' => url('/academic-years')],
['name' => __('edit').' '.__('academic year'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>تعديل الاعدادات</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($academic_year, ['method'=>'put','route'=>['academic-years.update',$academic_year->id],'files'=>'true'])!!}
                    @include('settings::academic_years.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
