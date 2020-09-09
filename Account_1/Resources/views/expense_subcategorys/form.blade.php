
<input type="hidden" name="selector" value="{{ !isset($resource)? 'create' : 'edit' }}FormContainer" >
<div id="{{ !isset($resource)? 'create' : 'edit' }}FormContainer" >
<table class="table" >
    <tr>
        <td style="width: 200px" >
            <b>{{  __('expense_maincategorys') }} *</b>
        </td>
        <td>
            <select name="expenses_maincategory_id" required=""  class="form-control expenses_maincategory_id" >
                <option></option>
                @foreach(\Modules\Account\Entities\ExpenseMainCategory::all() as $row)
                <option value="{{ $row->id }}"
                        data-value="{{ $row->value }}"
                        @if (isset($resource))
                        @if ($row->id == $resource->id)
                        selected=''
                        @endif
                        @endif >{{ $row->name }} [{{ number_format($row->value) }} EGP]</option>
                @endforeach
            </select> 
        </td>
    </tr>
</table> 
<br>
<br>
<table class="table table-border" id="{{ !isset($resource)? 'create' : 'edit' }}Table" >
    <tr class="w3-light-gray" >
        <th>{{ __('name') }} *</th>
        <th>{{ __('value') }} *</th>
        <th>{{ __('priority') }} *</th>
        <th>{{ __('store') }} *</th>  
        <th>{{ __('notes') }}</th>
        <th></th>
    </tr>
    
    @if (isset($resource))
    @foreach($resource->expenseSubCategories()->get() as $item)
    <tr> 
        <td>
            <input type="hidden" name="id[]" value="{{ $item->id }}" >
            <input type="text" name="name[]" required="" value="{{ $item->name }}" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="value[]" required="" value="{{ $item->value }}" class="value form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="priority[]" required="" value="{{ $item->priority }}" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <select name="store_id[]" required=""  class="form-control form-control-sm font-large" >
                <option></option>
                @foreach(\Modules\Account\Entities\Store::all() as $row)
                <option value="{{ $row->id }}"
                        {{ $row->id == optional($item->store)->id? 'selected' : '' }}>{{ $row->name }} [{{ number_format($row->balance) }}]</option>
                @endforeach
            </select> 
        </td>
        <td>
            <input type="text" name="notes[]" value="{{ $item->notes }}" class="form-control form-control-sm font-large" > 
        </td>
        <td>
            <button type="button" class="btn w3-red fa fa-trash btn-sm" onclick="var tr = $(this).parent().parent(); confirmMessage(function(){ tr.remove(); })" ></button>
        </td>
    </tr>
    @endforeach
    @endif
    
     

</table> 
<br>
<table class="table" >
    <tr>
        <td><button type="button" class="btn btn-default fa fa-plus btn-sm" onclick="addRow('{{ !isset($resource)? 'create' : 'edit' }}Table')" ></button></td>
    </tr>
</table> 



</div>