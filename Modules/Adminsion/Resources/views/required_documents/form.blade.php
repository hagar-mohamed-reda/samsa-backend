<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('name') }} </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('name') ])!!}
                @error('name')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <ul class="list-unstyled mb-0">

                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con"   >
                            <input type="radio" name="type" checked="" value="original">
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('original') }}</span>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con"  >
                            <input type="radio" name="type" value="copy">
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('copy') }}</span>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con" >
                            <input type="radio" name="type" value="both">
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('both') }}</span>
                        </div>
                    </fieldset>
                </li>
            </ul>
            @error('type')
            <span class="text-danger"> {!! $message !!}</span>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes') ])!!}
                <div class="help-block"></div></div>
        </div>
    </div>
</div>


