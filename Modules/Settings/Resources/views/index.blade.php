@extends('layouts.admin')

@section('content')
<div class="card">
    @permission('settings_create')
    <div class="card-header">
        <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('settings.create')}}"><i class="ik ik-plus-circle"></i>اضافة اعدادات</a>
    </div>
    @endpermission
    <div class="card-content">

        <div class="table-responsive">
            {!! Form::open(['method'=>'post','route'=>'settings.store'])!!}
            @include('settings::form')
            <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
