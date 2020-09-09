 
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
        <th style="width: 150px" > {{ __('value') }} * </th>
        <td>
            {!! Form::number('value',null,['class'=>'form-control', 'required'])!!}
            @error('value')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>  
    <tr>
        <th style="width: 150px" > {{ __('priority') }} * </th>
        <td>
            {!! Form::number('priority',null,['class'=>'form-control', 'required'])!!}
            @error('priority')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>  
    <tr>
        <th>{{ __('store') }}</th>
        <td>
            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'placeholder' => ''])!!} 
            @error('store_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('academic_year') }} *</th>
        <td>
            {!! Form::select('academic_year_id',\Modules\Settings\Entities\AcademicYear::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
            @error('academic_year_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr>
    <tr>
        <th>{{ __('level') }} *</th>
        <td>
            {!! Form::select('level_id',\Modules\Settings\Entities\Level::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
            @error('level_id')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror 
        </td>
    </tr> 
    <tr>
        <th>{{ __('user') }} *</th>
        <td>
            {!! Form::select('user_id',App\User::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
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


