@extends('layouts.admin')
@section('title') {{ __('military course collection students') }} @endsection

@section('content')
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-content">
        <div class="table-responsive">
            {!! Form::open(['method'=>'post','route'=>'military-course-students.store'])!!}

            @include('military::military_course_collection_students.table')
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
