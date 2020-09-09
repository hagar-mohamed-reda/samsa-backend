<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('qualification name') }} </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('qualification name')])!!}
                @error('name')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="grade"> {{ __('qualification grade') }} </label>
                {!! Form::text('grade',null,['class'=>'form-control','id'=>'grade','placeholder'=> __('qualification grade') ])!!}
                @error('grade')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <fieldset>
                    <div class="vs-checkbox-con vs-checkbox-primary">
                        <input type="checkbox"  @if(isset($qualification) && $qualification->is_azhar==1) checked @endif  value="1" name="is_azhar">
                               <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                                <i class="vs-icon feather icon-check"></i>
                            </span>
                        </span>
                        <span class=""> {{ __('is azhary') }} </span>
                    </div>
                </fieldset>
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

