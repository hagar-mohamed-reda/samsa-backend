<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('department name') }} </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('department name') ])!!}
                @error('name')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('level') }}</label>
                {!! Form::select('level_id',Modules\Divisions\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => '- اختر المستوى الدراسى -'])!!}
                @error('level_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
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


