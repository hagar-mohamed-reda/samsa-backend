@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>تعديل الاعدادات</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($setting, ['method'=>'put','route'=>['settings.update',$setting->id],'files'=>'true'])!!}
                    @include('settings::form')
                    <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
