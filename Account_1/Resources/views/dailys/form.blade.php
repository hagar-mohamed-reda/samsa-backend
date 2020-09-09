<table class="table" >
    <tr>
        <th>{{ __('date') }} *</th>
        <td>
            {!! Form::date('date',null,['class'=>'form-control', 'required'])!!} 
        </td>
    </tr>
    <tr>
        <th>{{ __('store') }} *</th>
        <td>
            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select','id'=>'customSelect', 'required' ])!!} 
        </td>
    </tr>
    <tr   >
        <th style="width: 150px" > {{ __('value') }} * </th>
        <td>
            {!! Form::number('value',null,['class'=>'form-control', 'required'])!!} 
        </td>
    </tr>   
    <tr>
        <th>{{ __('notes') }}</th>
        <td>
            {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => '4' ])!!} 
        </td>
    </tr>
    <tr>
        <th>{{ __('tree') }}</th>
        <td>
            @include('account::trees.tree')
        </td>
    </tr>

</table> 


