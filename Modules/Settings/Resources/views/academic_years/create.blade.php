@extends('layouts.admin')
@section('title') السنوات الدراسية @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('academic year'), 'url' => url('/academic-years')],
['name' => __('add').' '.__('academic year'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>اضافة عام دراسى</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'post','route'=>'academic-years.store'])!!}
                @include('settings::academic_years.form')
                <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
