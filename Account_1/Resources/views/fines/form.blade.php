 

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

</table> 


