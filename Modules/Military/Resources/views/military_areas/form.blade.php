<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('area name') }} </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('area name') ])!!}
                @error('name')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place"> {{ __('government') }} </label>
                {!! Form::select('government_id',App\Government::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('government') ])!!}
                @error('government_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
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
