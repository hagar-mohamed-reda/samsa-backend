@extends('layouts.admin')
@section('title') {{ __('military course collection') }} @endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('edit') }} </h3>
                </div>
                <div class="card-body">
                    {!! Form::model($row, ['method'=>'put','route'=>['military-course-collection.update',$row->id],'files'=>'true'])!!}
                    @include('military::military_course_collection.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> {{ __('save') }} </button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
