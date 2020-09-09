    	
<table class="table" >
    <input type="hidden" value="main" name="type" >
    <tr>
        <th>{{ __('date_from') }} *</th>
        <td>
            {!! Form::date('date_from',null,['class'=>'form-control', 'required'])!!}
            @error('date_from')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('date_to') }} *</th>
        <td>
            {!! Form::date('date_to',null,['class'=>'form-control', 'required'])!!}
            @error('date_to')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('value') }} *</th>
        <td>
            {!! Form::text('value',null,['class'=>'form-control', 'required'])!!}
            @error('value')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('student') }} *</th>
        <td>
            {!! Form::select('student_id',\Modules\Student\Entities\Student::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
            @error('student_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('target') }} *</th>
        <td>
            @php
                $type = [
                    'madunia' => __('madunia') 
                ];
            @endphp
            {!! Form::select('target', $type,null,['class'=>'custom-select','id'=>'customSelect', 'required' ])!!} 
            @error('target')
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


