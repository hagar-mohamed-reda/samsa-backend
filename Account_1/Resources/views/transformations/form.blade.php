      
<table class="table" >
    <tr>
        <th>{{ __('date') }} *</th>
        <td> 
            {!! Form::date('date',null,['class'=>'form-control', 'required'])!!}
            @error('date')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('bank') }} *</th>
        <td>
            {!! Form::select('bank_id',\Modules\Account\Entities\Bank::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select','id'=>'customSelect', 'required' ])!!} 
            @error('bank_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('store') }} *</th>
        <td>
            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select','id'=>'customSelect', 'required' ])!!} 
            @error('store_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('type') }} *</th>
        <td>
            @php
                $type = [
                    '' => __('select type'),
                    'bank_to_store' => __('bank_to_store'),
                    'store_to_bank' => __('store_to_bank')
                ];
            @endphp
            {!! Form::select('type', $type,null,['class'=>'custom-select','id'=>'customSelect', 'required' ])!!} 
            @error('type')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
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


