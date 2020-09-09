<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name">{{ __('qualification type name') }}</label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('qualification type name')])!!}
                @error('name')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="grade"> {{ __('required grade') }} </label>
                {!! Form::text('grade',null,['class'=>'form-control','id'=>'grade','placeholder'=> __('grade') ])!!}
                @error('grade')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="grade"> {{ __('percentage') }} </label>
                {!! Form::text('percentage',null,['class'=>'form-control','id'=>'grade','placeholder'=> __('percentage') ])!!}
                @error('percentage')
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
                <label class="label-r" for="title"> {{ __('qualification') }} </label>
                {!! Form::select('qualification_id',\Modules\Settings\Entities\Qualification::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('qualification') ])!!}
                    @error('qualification_id')
                        <span class="text-danger"> {!! $message !!}</span>
                    @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="title"> {{ __('level') }} </label>
                {!! Form::select('level_id',\Modules\Settings\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('level') ])!!}
                    @error('level_id')
                        <span class="text-danger"> {!! $message !!}</span>
                    @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes')])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>

