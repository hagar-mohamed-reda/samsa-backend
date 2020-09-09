@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/select2/css/select2.min.css">
@endsection

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('military area') }}</label>
                {!! Form::select('military_area_id', Modules\Military\Entities\MilitaryAreas::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('select military area') ])!!}
                @error('military_area_id')
                <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('government') }}</label>
                {!! Form::select('government_id',App\Government::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('select government') ])!!}
                @error('government_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    @if (isset($status))
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('city') }}</label>
                {!! Form::select('city_id',App\City::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect' ])!!}
                @error('city_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('city') }}</label>
                {!! Form::select('city_id[]',App\City::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'multiple' => '' ])!!}
                @error('city_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    @endif
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="end_date"> {{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes')])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>
@section('more_scripts')
<script src="{{ url('/') }}/app-assets/select2/js/select2.min.js" ></script>
 <script>  
     $('.select2').select2();
 </script> 
@endsection