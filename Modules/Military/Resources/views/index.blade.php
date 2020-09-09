@extends('layouts.admin')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('military setting'), 'active' => true], 
];
@endphp

@section('content')

@include('layouts.breadcrumb', ['links' => $links])
 
<div class="card">
    <div class="card-header" style="padding-bottom: 1.5rem;">
        <h4 class="card-title">{{ __('date of age calculate') }} </h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" class=""><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse " style="">
        <div class="card-body">
            <form method="post" action="{{ route('SettingUpdate', 4) }}" >
                @csrf 
                <div> 
                    <input type="date" name="value" class="form-control" value="{{ getSetting(4) }}" >
                </div>
                <div>
                    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light btn-sm" >{{ __('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

 
@endsection

@section('more_scripts') 
<script>
     
</script> 
@endsection
 