<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name">{{ __('division name') }}</label>
                {!! Form::text('name',null,['required'=>'required','class'=>'form-control','id'=>'name','placeholder'=> __('division name') ])!!}
                @error('name')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            <div class="help-block"></div></div>
        </div>
    </div>
   
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">اختر الستوى الدراسى</label>
                {!! Form::select('level_id',Modules\Divisions\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => '- اختر المستوى الدراسى -'])!!}
                @error('level_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label class="label-r" for="national_id_place">{{ __('department name') }}</label>
                {!! Form::select('department_id',Modules\Divisions\Entities\Department::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('department name') ])!!}
                @error('department_id')
                    <span class="text-danger"> {!! $message !!}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <div class="controls">
                <label for="notes">{{ __('notes') }}</label>
                {!! Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','placeholder'=> __('notes') ])!!}
            <div class="help-block"></div></div>
        </div>
    </div>
</div>


@section('more_scripts')
<script>
    var array = [];
    console.log('scripts');
    $("select[name=level_id]")[0].onchange = function(){
        console.log('changed');
        loadGovernmentBasicOnCountry(this.value);
    };

    function loadGovernmentBasicOnCountry(levelId) {
        $.get("{{ url('department/') }}/" + levelId, function(result){
            array = [];
            setGoverOptions(result);
        });
    }

    function setGoverOptions(array) {
        $("select[name=department_id]").children().remove();
        for(var row in array) {
            var option = document.createElement('option');
            option.value = array[row];
            option.innerHTML = row;
            $("select[name=department_id]").append(option);
        }
    }
    
    
</script>
@if (isset($devision))
<script>  
    $('#academic_year_id').val('{{ $devision->academic_year_id }}'); 
    $('select[name=level_id]').val('{{ optional($devision->department)->level_id }}');
</script>
@else
<script>
    loadGovernmentBasicOnCountry('0');
</script>
@endif 
@endsection
