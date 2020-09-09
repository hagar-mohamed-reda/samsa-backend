<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('military status') }}  </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('military status') ])!!}
            <div class="help-block"></div></div>
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
