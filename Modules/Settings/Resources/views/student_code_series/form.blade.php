<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name">{{ __('code') }}</label>
                {!! Form::text('code',null,['class'=>'form-control','id'=>'code','placeholder'=> __('code')])!!}
                @error('name')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div> 

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="academic_year_id"> {{ __('academic_year') }} </label>
                {!! Form::select('academic_year_id',\Modules\Settings\Entities\AcademicYear::pluck('name','id'),null,['class'=>'custom-select','id'=>'academic_year_id', 'placeholder' => __('academic_year') ])!!}
                    @error('academic_year_id')
                        <span class="text-danger"> {!! $message !!}</span>
                    @enderror
            </div>
        </div>
    </div>
      
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="level_id"> {{ __('level') }} </label>
                {!! Form::select('level_id',\Modules\Settings\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('level') ])!!}
                    @error('level_id')
                        <span class="text-danger"> {!! $message !!}</span>
                    @enderror
            </div>
        </div>
    </div>
    
</div>

