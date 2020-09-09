@extends('reports::layouts.master')

@section('title')
{{ __('registration_certificate') }}
@endsection

@section('breadcrumbs')

 @php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('report'), 'active' => true],
['name' => __('registration_certificate'), 'active' => true], 
];
@endphp

@include('layouts.breadcrumb', ['links' => $links]) 
<div class="card" >
    <div class="card-body" >
        <form  method="get" action="" >
            <div class="row" >
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="controls">
                        <label class="label-r" for="national_id_place">{{ __('student name') }}</label>
                        {!! Form::select('student_id',Modules\Student\Entities\Student::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('select student')])!!}
                         
                    </div>
                </div>
            </div> 
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button> 
                </div>
        </div>
        </form>
    </div>
</div>
@endsection
 

@section('body')
    @include('reports::layouts.header1')
    <br>
    {!! str_replace("{student}", isset($student)? $student->name : '', $html) !!}
    <br>
    @include('reports::layouts.footer1')
@endsection