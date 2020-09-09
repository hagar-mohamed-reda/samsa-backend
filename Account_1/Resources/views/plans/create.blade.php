@extends('layouts.admin')
@section('title')   @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('installment'), 'url' => url('/academic-years')],
['name' => __('install'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

<table class="hidden" >
    <tr class="hidden clone-row" >
        <td>
            <input type="hidden" name="id[]" value="0" >  
            <input type="date" name="date_from[]"   required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="date" name="date_to[]"  required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="values[]" onkeyup="calculateSum()" required=""  class="form-control form-control-sm font-large value" >
        </td>  
        <td class="w3-display-container" >
            <button type="button" class="shadow btn w3-red btn-sm font-large" onclick="$(this).parent().parent().find('.expense_maincategory_table').slideToggle(500)" >{{ __('expense_maincategories') }}</button>
            
        </td>  
        <td>
            <select name="fine_id[]"  class="form-control form-control-sm font-large" >
                <option value="" >{{ __('select all') }}</option>
                @foreach(Modules\Account\Entities\Fine::get() as $item)
                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                @endforeach
            </select>
        </td> 
        <td class="w3-display-container">
            <input type="text" name="noteses[]" class="form-control form-control-sm font-large" > 
            <input type="hidden" name="expense_maincategory_ids[]" class="expense_maincategory_ids" >
            <div class="w3-display-bottomright expense_maincategory_table" style="display: none" >
                <div class="w3-white material-shadow" >
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>{{ __('name') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach(\Modules\Account\Entities\ExpenseMainCategory::get() as $item)
                            <tr>
                                <td>  
                                    {{ $item->name }}
                                </td>
                                <td>
                                    <div class="vs-checkbox-con vs-checkbox-primary "> 
                                        <input type="checkbox" class="checkbox-input" value="" data-id="{{ $item->id }}"  onchange="setExpense(this)"    >
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
            </div>
        </td>
        <td>
            <button type="button" class="btn w3-red fa fa-trash btn-sm shadow" onclick="removeRow(this)" ></button>
        </td>
    </tr> 
</table> 

<div class="box material-shadow"  >
    <div class="box-body"  >
        {!! Form::open(['method'=>'post','route'=>'plans.store', 'files'=>'true', 'class'=> 'form'])!!}
        <div class="box-header">
            <div class="text-center w3-block modal-title w3-xlarge" >
                {{ __('add plan') }} 
            </div>   
        </div>  
        <div class="modal-body"> 
            @include('account::plans.form') 
        </div>
        <div class="modal-footer text-center">
            <center>
                <button type="button" class="btn btn-default shadow" data-dismiss="modal">{{ __('close') }}</button>
                <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
            </center>
        </div> 
        {!!Form::close()!!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection