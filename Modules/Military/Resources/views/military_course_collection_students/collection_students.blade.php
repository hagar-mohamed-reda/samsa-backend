

@extends('layouts.admin')
@section('title') {{ __('military course collection') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('military course collection'), 'url' => url('/military-course-collection')],
['name' => __('military course collection students'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])


@if(count($students) <=  0) 
<dialog open> {{ __('sorry no students found on this military collection') }} </dialog>
@else

{!! Form::open(['method'=>'post','route'=>'postCollectionStudents'])!!}
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-border w3-bordered" id="table">
                <thead>
                    <tr class="w3-dark-gray" >
                        <th scope="col" class="w3-large" >ID</th>
                        <th class="w3-large" >{{ __('name') }}</th>
                        <th class="w3-large">{{ __('national id') }}</th>
                        <th class="w3-large">{{ __('code') }}</th>
                        <th class="w3-large">{{ __('precipitate') }} / {{ __('successfull')}}</th>
                        <th class="w3-large">{{ __('delete') }} </th>
                    </tr>
                </thead>
                <tbody>
                <input hidden type="text" name="military_course_collection_id" value="{{ $collection->id }}">

                @foreach ($students as $row )
                <tr>
                    <th scope="row" >
                        {!! $row->student->id !!}
                    </th>
                    <th scope="row" >
                        {!! $row->student->name !!}
                    </th>
                    <td>
                        {!! $row->student->national_id !!}
                    </td>
                    <td>
                        {!! $row->student->code !!}
                    </td>
                    <td>
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox"
                                   class="requirement-input"
                                   value="{{ $row->student->id }}"
                                   name = "students[]"
                                   @if($row->status == 1) checked @endif>
                                   <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class=""></span>
                        </div>
                    </td>
                    <td>
                        <a href="{{url('delete-military-cource-student/'.$row->student->id)}}" id="type-warning">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                            </div>
                        </a>
                        
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            <div class="w3-center" >
                <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" >{{ __('save') }}</button> 
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endif
@endsection

