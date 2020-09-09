@extends('layouts.admin')
@section('title') {{ __('applications') }} @endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3> {{ __('add') }} </h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['method'=>'post','route'=>'applicationStore',  'files'=>'true'])!!}
                    @include('adminsion::applications.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
