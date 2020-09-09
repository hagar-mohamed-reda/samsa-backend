
@section('custom-style')
<style>
    .type_section {
        display: none;
    }
</style>
@endsection
<table class="table" >
    @if (isset($installment))
    <tr>
        <th class=" " >{{ __('date_from') }}</th>
        <td>
            <input type="hidden" name="installment_id" value="{{ $installment->id }}" >
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
    @endif
    
    
    <tr>
        <th>{{ __('value') }} *</th>
        <td> 
            {!! Form::number('value',null,['class'=>'form-control', 'required'])!!}
            @error('value')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('date') }} *</th>
        <td> 
            {!! Form::date('date',null,['class'=>'form-control', 'required'])!!}
            @error('date')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr class="" >
        <th>{{ __('reword_id') }}</th>
        <td>
            <select class="form-control select2" name="reword_id" 
                    onchange="setDiscount(this)"  >
                <option value="" data-value="0" >{{ __('select all') }}</option>
                @foreach(\Modules\Account\Entities\Reword::get() as $item)
                <option value="{{ $item->id }}" data-value="{{ $item->value }}" >{{ $item->name }}</option>
                @endforeach
            </select>
            @error('reword_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th class=" " >{{ __('discount') }}</th>
        <td>
            {!! Form::number('discount',null,['class'=>'form-control discount', 'onkeyup' => 'calculateDiscount(this.value)'])!!}
        </td>
    </tr>
    <tr>
        <th>{{ __('payment_type') }} *</th>
        <td>
            @php
            $type = [
            '' => __('select payment_type'),
            'store' => __('for_store'),
            'check' => __('for_check')
            ];
            @endphp
            {!! Form::select('payment_type', $type,null,['class'=>'custom-select','id'=>'customSelect', 'required', 'onchange' => 'changeType(this.value)' ])!!} 
            @error('type')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr> 
    <tr class="store_type type_section" >
        <th>{{ __('store') }} *</th>
        <td>
            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select payment_type store_id','id'=>'customSelect', 'required' ])!!} 
            @error('store_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
     
    <tr class="check_type type_section" >
        <th class=" " >{{ __('check_number') }}</th>
        <td> 
            {!! Form::text('check_number',null,['class'=>'form-control' ])!!}
            @error('check_number')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr class="check_type type_section" >
        <th class=" " >{{ __('account_number') }}</th>
        <td> 
            {!! Form::text('account_number',null,['class'=>'form-control' ])!!}
            @error('account_number')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr class="check_type type_section" >
        <th class=" " >{{ __('bank_name') }}</th>
        <td> 
            {!! Form::text('bank_name',null,['class'=>'form-control' ])!!}
            @error('bank_name')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr class="check_type type_section" >
        <th class=" " >{{ __('branch') }}</th>
        <td>  
            {!! Form::text('branch',null,['class'=>'form-control' ])!!}
            @error('branch')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('notes') }}</th>
        <td>
            {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => '4' ])!!}
            @error('notes')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr> 
    <tr>
        <th>{{ __('attachment') }}</th>
        <td>
            {!! Form::file('attachment',null,['class'=>'form-control'])!!}
            @error('attachment')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr> 

</table> 

@section('more_scripts')

    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
<script>
    var html = $('.clone-row').html();
    
    function setDiscount(select) {
        var value = $(select).find("option[value="+select.value+"]").attr('data-value');
        $('.discount').val(value);
        calculateDiscount(value);
    }
 
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
        changeType('{{ isset($resource)? $resource->payment_type : "" }}');
        calculateDiscount({{ isset($resource)? $resource->discount : 0 }});
        formAjax(null, function(){
            window.location.reload();
        });
        calculateSum(); 
        // assign values
        $('select[name=payment_type]').val('{{ isset($resource)? $resource->payment_type : "" }}');
        $('select[name=store_id]').val('{{ isset($resource)? $resource->store_id : "" }}');
        $('input[name=check_number]').val('{{ isset($resource)? $resource->check_number : "" }}');
        $('input[name=account_number]').val('{{ isset($resource)? $resource->account_number : "" }}');
        $('input[name=bank_name]').val('{{ isset($resource)? $resource->bank_name : "" }}');
        $('input[name=branch]').val('{{ isset($resource)? $resource->branch : "" }}');
        
        //convertAjax(document.getElementById('installForm'));
    });
</script>
@endsection

