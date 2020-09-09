<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('military course collection code') }}  </label>
                {!! Form::text('code',null,['class'=>'form-control','id'=>'name','placeholder'=> __('military course collection code') ])!!}
                @error('code')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="military_course_id 	">{{ __('military course') }}</label>
                {!! Form::select('military_course_id',Modules\Military\Entities\MilitaryCourse::pluck('name','id'),null,['required'=>'required','id'=>"country",'class'=>'custom-select','id'=>'customSelect', 'placeholder' =>__('select military course')])!!}
                @error('military_course_id 	')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="start_date"> {{ __('starts in') }} </label>
                {!! Form::date('starts_in',null,['class'=>'form-control','id'=>'start_date','placeholder'=> __('starts in')])!!}
                @error('starts_in')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date"> {{ __('ends in') }} </label>
                {!! Form::date('ends_in',null,['class'=>'form-control','id'=>'end_date','placeholder'=> __('ends in') ])!!}
                @error('ends_in')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="notes">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes')])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>
