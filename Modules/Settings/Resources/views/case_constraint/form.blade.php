<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('case constraint name') }}</label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('case constraint name')])!!}
            <div class="help-block"></div></div>
        </div>
    </div>

      <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=>  __('notes')])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>

