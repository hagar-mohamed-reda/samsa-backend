<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('condition age') }} </label>
                {!! Form::number('condition_age',null,['class'=>'form-control','id'=>'name','placeholder'=> __('condition age') ])!!}
                @error('condition_age')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place"> {{ __('military status') }} </label>
                {!! Form::select('military_status_id',Modules\Military\Entities\MilitaryStatus::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('military status') ])!!}
                @error('military_status_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    
     <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">{{ __('reasons') }}</label>
                {!! Form::textarea('reason',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('reason') ])!!}
                @error('reason')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    
    
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes') ])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>
