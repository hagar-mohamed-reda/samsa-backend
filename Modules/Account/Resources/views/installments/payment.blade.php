@extends('layouts.admin')
@section('title')   @endsection

@section('custom-style')
<style>
    .type_section {
        display: none;
    }
</style>
@endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('installment'), 'url' => url('/academic-years')],
['name' => $installment->id, 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
 
<div class="box shadow install-container" >
    <form method="post" action="{{ route('installments.storePay', $installment->id) }}" id="installForm" class="form" >
        @csrf
        <input type="hidden" name="id" value="{{ $resource->id }}" >
        <input type="hidden" name="user_id" value="{{ $installment->user_id }}" >
        <input type="hidden" name="installment_id" value="{{ $installment->id }}" >
        <input type="hidden" name="student_id" value="{{ $installment->student_id }}" >
        <input type="hidden" name="type" value="sub" >
        <div class="box-header" >

        </div>
        
        <div class="box-header" >
            <h4>{{ __('pay installment') }} {{ $installment->id }}</h4>
        </div>
        <div class="box-body" >
            <table class="table" >
                <tr>
                    <th class=" " >{{ __('date_from') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ $installment->date_from }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('date_to') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ $installment->date_to }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('value') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large installment_value" value="{{ $installment->value }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('student') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ optional($installment->student)->name }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('user') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ optional($installment->user)->name }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('value') }}</th>
                    <td>
                        <input type="number" name="value" required=""
                               readonly=""
                               max="{{ $installment->value }}" 
                               class="form-control form-control-sm font-large  payment_value" 
                               value="{{ $installment->value }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('date') }}</th>
                    <td> 
                        <input type="date" name="date" required="" class="form-control form-control-sm font-large" value="{{ $resource->date }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('discount') }}</th>
                    <td>
                        <input type="number" name="discount" required="" 
                               class="form-control form-control-sm font-large" 
                               onkeyup="calculateDiscount(this.value)" 
                               value="{{ $resource->discount }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('payment_type') }}</th>
                    <td>
                        <select class="form-control form-control-sm payment_type font-large "  required=""
                                onchange="changeType(this.value)" name="payment_type" >
                            <option></option>
                            <option value="store" >{{ __('for_store') }}</option>
                            <option value="check" >{{ __('for_check') }}</option>
                        </select>
                    </td>
                </tr>
                
                <tr class="store_type type_section" >
                    <th class=" " >{{ __('store') }}</th>
                    <td>
                        <select class="form-control form-control-sm payment_type store_id font-large store_id" name="store_id" >
                            <option></option>
                            @foreach(Modules\Account\Entities\Store::all() as $item)
                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="check_type type_section" >
                    <th class=" " >{{ __('check_number') }}</th>
                    <td>
                        <input type="text" name="check_number" 
                               class="form-control form-control-sm font-large" 
                               value="{{ $resource->check_number }}" > 
                    </td>
                </tr>
                <tr class="check_type type_section" >
                    <th class=" " >{{ __('account_number') }}</th>
                    <td>
                        <input type="text" name="account_number" 
                               class="form-control form-control-sm font-large" 
                               value="{{ $resource->account_number }}" > 
                    </td>
                </tr>
                <tr class="check_type type_section" >
                    <th class=" " >{{ __('bank_name') }}</th>
                    <td>
                        <input type="text" name="bank_name" 
                               class="form-control form-control-sm font-large" 
                               value="{{ $resource->bank_name }}" > 
                    </td>
                </tr>
                <tr class="check_type type_section" >
                    <th class=" " >{{ __('branch') }}</th>
                    <td>
                        <input type="text" name="branch" 
                               class="form-control form-control-sm font-large" 
                               value="{{ $resource->branch }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('notes') }}</th>
                    <td>
                        <input type="text" name="notes" 
                               class="form-control form-control-sm font-large" 
                               value="{{ $resource->notes }}" > 
                    </td>
                </tr>
                <tr>
                    <th>{{ __('attachment') }}</th>
                    <td>
                        {!! Form::file('attachment',null,['class'=>'form-control'])!!}
                        @if ($resource->attachment)
                        <img src="{{ $resource->attachment_url }}" width="40px" >
                        @endif
                    </td>
                </tr>
                 
            </table>
            <br> 
            <br> 
            <br>
            <div class="w3-padding" >
                <center>
                    <a role="button" class="btn btn-default shadow" href="{{ route('installments.index') }}" data-dismiss="modal">{{ __('close') }}</a>
                    <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
                </center>
            </div>
        </div>
    </form>
</div> 
@endsection

@section('more_scripts')

    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
<script>
    var html = $('.clone-row').html();
 
    function calculateDiscount(discount) {
        if (discount < 0)
            return;
        var value = $(".installment_value").val(); 
        value  -= discount;
         
        $(".payment_value").val(value);
    }
    
    function changeType(type) {
        if (type == 'store') {
            $('.type_section').slideUp(500);
            $('.store_type').slideDown(500);
            $('.store_type select, .store_type input').attr('required', "required");
            $('.check_type select, .check_type input').removeAttr('required');
            //
        }
        if (type == 'check') {
            $('.type_section').slideUp(500);
            $('.check_type').slideDown(500);
            $('.check_type select, .check_type input').attr('required', "required");
            $('.store_type select, .store_type input').removeAttr('required');
        }
    }
    function calculateSum() {
        var sum = 0;
        $('.value').each(function () {
            //
            console.log(this.value);
            if (this.value > 0)
                sum += parseFloat(this.value);
        });
        
        console.log(sum);
        $('.sum').val(sum);
    }

    function addRow() {
        var row = document.createElement("tr");
        //
        row.innerHTML = html;
        // 
        $("#installTable").append(row);
        calculateSum();
    }

    function removeRow(button) {
        var tr = $(button).parent().parent();
        confirmMessage(function () {
            tr.remove();
            calculateSum();
        });
    }
    
 
    $(document).ready(function () {
        changeType('{{ $resource->payment_type }}');
        calculateDiscount({{ $resource->discount? $resource->discount : 0 }});
        convertAjax(document.getElementById('installForm'), function(r){ window.location.reload() }, false);
        calculateSum(); 
        // assign values
        $('select[name=payment_type]').val('{{ $resource->payment_type }}');
        $('select[name=store_id]').val('{{ $resource->store_id }}');
        $('input[name=check_number]').val('{{ $resource->check_number }}');
        $('input[name=account_number]').val('{{ $resource->account_number }}');
        $('input[name=bank_name]').val('{{ $resource->bank_name }}');
        $('input[name=branch]').val('{{ $resource->branch }}');
        
        //convertAjax(document.getElementById('installForm'));
    });
</script>
@endsection

