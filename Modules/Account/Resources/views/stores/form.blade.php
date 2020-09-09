 

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
        <th>{{ __('address') }}</th>
        <td>
            {!! Form::text('address',null,['class'=>'form-control' ])!!}
            @error('address')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('user') }} *</th>
        <td>
            {!! Form::select('user_id',App\User::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'placeholder' => ''])!!}

            @error('user_id')
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


