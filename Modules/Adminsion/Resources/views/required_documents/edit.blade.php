@extends('layouts.admin')
@section('title') {{ __('required_documents') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('required_documents'), 'url' => url('/required_documents')],
['name' => __('edit').' '.__('required_documents'), 'active' => true],
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
                    {!! Form::model($requiredDocument, ['method'=>'put','route'=>['required_documents.update',$requiredDocument->id],'files'=>'true'])!!}
                    @include('adminsion::required_documents.form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
