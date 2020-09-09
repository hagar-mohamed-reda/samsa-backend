 

<table class="table" >
    <tr>
        <th>{{ __('name') }} *</th>
        <td>
            {!! Form::text('name',null,['class'=>'form-control', 'required'])!!}
            @error('name')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('account_number') }} *</th>
        <td>
            {!! Form::text('account_number',null,['class'=>'form-control', 'required'])!!}
            @error('account_number')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr> 
    <tr class="balance_tr" >
        <th style="width: 150px" > {{ __('init_balance') }} * </th>
        <td>
            {!! Form::number('init_balance',null,['class'=>'form-control', 'required'])!!}
            @error('balance')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>   
    <tr>
        <th>{{ __('branche') }}</th>
        <td>
            {!! Form::text('branche',null,['class'=>'form-control' ])!!}
            @error('branche')
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

</table> 


