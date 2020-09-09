@extends('layouts.admin')
@section('title') {{ __('divisions') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('divisions'), 'active' => true], 
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
                        <label class="label-r" for="national_id_place">{{ __('department name') }}</label>
                        {!! Form::select('department_id',Modules\Divisions\Entities\Department::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('department name') ])!!}
                        @error('department_id')
                            <span class="text-danger"> {!! $message !!}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button>
                    <a role="button" href="{{ route('divisions.index') }}" class="btn btn-danger waves-effect waves-light">{{ __('select all') }}</a>
                </div>
        </div>
        </form>
    </div>
</div>

<div class="card">
    @permission('divisions_create')
    <div class="card-header w3-border-bottom w3-border-light-gray"  >
        <a href="{{route('divisions.create')}}"class="btn btn-social btn-relief-primary">
            <i class="fa fa-plus"></i> {{ __('add') }}
        </a> 
    </div>
    @endpermission
    <div class="card-body">
        <div class="table-responsive">
            @include('divisions::divisions.table')
        </div>
    </div>
</div>

@endsection

@section('more_scripts')
<script>
    var array = [];
    console.log('scripts');
    $("select[name=level_id]")[0].onchange = function(){
        console.log('changed');
        loadGovernmentBasicOnCountry(this.value);
    };

    function loadGovernmentBasicOnCountry(levelId) {
        $.get("{{ url('department/') }}/" + levelId, function(result){
            array = [];
            setGoverOptions(result);
        });
    }

    function setGoverOptions(array) {
        $("select[name=department_id]").children().remove();
        for(var row in array) {
            var option = document.createElement('option');
            option.value = array[row];
            option.innerHTML = row;
            $("select[name=department_id]").append(option);
        }
    }
</script> 
@endsection

