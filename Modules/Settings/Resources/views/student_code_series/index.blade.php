@extends('layouts.admin')
@section('title') 
{{ __('student_code_series') }} 
@endsection 

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('student_code_series'), 'active' => true], 
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
                        <label class="label-r" for="national_id_place">{{ __('level name') }}</label>
                        {!! Form::select('level_id',Modules\Divisions\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => '- اختر المستوى الدراسى -'])!!}
                        @error('level_id')
                            <span class="text-danger"> {!! $message !!}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="controls">
                        <label class="label-r" for="academic_year_id">{{ __('academic_year') }}</label>
                        {!! Form::select('academic_year_id',Modules\Settings\Entities\AcademicYear::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('academic_year') ])!!}
                        @error('academic_year_id')
                            <span class="text-danger"> {!! $message !!}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button>
                    <a role="button" href="{{ route('student-code-series.index') }}" class="btn btn-danger waves-effect waves-light">{{ __('select all') }}</a>
                </div>
        </div>
        </form>
    </div>
</div>

<div class="card">
    @permission('student-code-series_create')
    <div class="card-header w3-border-bottom w3-border-light-gray"  >
        <a href="{{route('student-code-series.create')}}" class="btn btn-social btn-relief-primary">
            <i class="fa fa-plus"></i> {{ __('add') }}
        </a> 
    </div>
    @endpermission
    <div class="card-body">
        <div class="table-responsive">
                @include('settings::student_code_series.table')
        </div>
    </div>
</div>

@endsection


