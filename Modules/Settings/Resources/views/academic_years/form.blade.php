<div class="row">
    <!--
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name">{{ __('name') }}</label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> date('Y') . "-" . (date("Y") + 1)])!!}
                 
                @error('name')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    -->
    
    @error('name')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="start_date"> يبدأ من </label>
                {!! Form::date('start_date',null,['class'=>'form-control','id'=>'start_date','placeholder'=>'يبدأ فى'])!!}
                @error('start_date')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date"> ينتهى فى</label>
                {!! Form::date('end_date',null,['class'=>'form-control','id'=>'end_date','placeholder'=>'ينتهى فى'])!!}
                @error('end_date')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
                <div class="help-block"></div></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date">ملاحظات</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=>'ملاحظات'])!!}
                <div class="help-block"></div></div>
        </div>
    </div>
</div>

