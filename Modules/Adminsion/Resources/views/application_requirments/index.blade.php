@extends('layouts.admin')
@section('title') 
{{ __('application requirements') }} 
@endsection 

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('application requirements'), 'active' => true], 
];
@endphp

@include('layouts.breadcrumb', ['links' => $links])

<div class="card"> 
    <div class="card-body">
        <div class="table-responsive">
            {!! Form::open(['method'=>'post','route'=>'application-requirments.store'])!!}

            <div class="">
                <table class="table table-border" id="table" >
                    <thead>
                        <tr>
                            <th>{{ __('field name') }}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>{{ __('select all') }}</th>
                            <th> 
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox"   value="false" onclick="checkAll()" >
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class=""></span>
                                    </div> 
                            </th>
                    </tr>
                        <tr>
                            <th>{{ __('deselect all') }}</th>
                            <th> 
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox"   value="false" onclick="deCheckAll()" >
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class=""></span>
                                    </div> 
                            </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($applicationRequirments as $applicationRequirment )

                        <tr>
                            <th scope="row"><label for="">{!! $applicationRequirment->display_name !!}</label></th>
                            <td> 
                                <input type="hidden" name="{{ $applicationRequirment->name }}" value="{{ $applicationRequirment->required? '1' : '0' }}"  class="input-value{{ $loop->iteration }}" >
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" 
                                               class="requirement-input"
                                               onchange="$('.input-value{{ $loop->iteration }}').val(this.checked? 1 : 0)"
                                               value="{{ $applicationRequirment->required? '1' : '0' }}"  
                                               {{ $applicationRequirment->required? 'checked' : '' }} >
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class=""></span>
                                    </div>  
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('more_scripts')
<script>
    function checkAll() {
        $('.requirement-input').each(function(){
            this.checked = true;
        });
    }
    
    function deCheckAll() {
        $('.requirement-input').each(function(){
            this.checked = false;
        });
    }

    $("#table").DataTable({
        "paging": false, 
        "sorting": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
        }, 
    });
</script>
@endsection


