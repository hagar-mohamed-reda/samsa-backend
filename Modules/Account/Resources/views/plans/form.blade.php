
         @csrf
        <input type="hidden" name="user_id" value=" " > 
       
            <table class="table" >
                <tr>
                    <th class=" " >{{ __('name') }} *</th>
                    <td>
                        {!! Form::text('name',null,['class'=>'form-control form-control-sm font-large', 'required'])!!} 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('expense_maincategory') }} *</th>
                    <td> 
                        {!! Form::select('expense_maincategory_id',\Modules\Account\Entities\ExpenseMaincategory::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required', 'placeholder' => __('select all') ])!!} 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('level') }} *</th>
                    <td> 
                        {!! Form::select('level_id',\Modules\Settings\Entities\Level::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required', 'placeholder' => __('select all') ])!!} 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('academic_year') }} *</th>
                    <td> 
                        {!! Form::select('academic_year_id',\Modules\Settings\Entities\AcademicYear::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required', 'placeholder' => __('select all') ])!!} 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('notes') }} </th>
                    <td> 
                        {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => '4' ])!!}
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('case_constaints') }} </th>
                    <td> 
                        <button type="button" class="shadow btn w3-indigo btn-sm font-large" onclick="$('.case_constaints_table').slideToggle(500)" >{{ __('select_case_constaints') }}</button>
                         
                        <table class="table case_constaints_table" style="display: none" >
                            <thead>
                                <tr>
                                    <th>{{ __('name') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(\Modules\Account\Entities\CaseConstraint::get() as $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="case_constraint_id[]" value="{{ $item->id }}" >
                                    {{ $item->name }}
                                </td>
                                <td>
                                    <div class="vs-checkbox-con vs-checkbox-primary "> 
                                        <input type="checkbox" class="checkbox-input" value="{{ $item->id }}"   name="case_constraint_check[]"
                                               @if($resource->caseContraints()->where('case_constraint_id', $item->id)->first())
                                               checked=""
                                               @endif
                                               >
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class=""></span>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                
            </table>
            <br>

            <table class="table table-border" id="installTable" >
                <tr class="w3-light-gray" >
                    <th>{{ __('date_from') }} *</th>
                    <th>{{ __('date_to') }} *</th>
                    <th>{{ __('value') }} *</th> 
                    <th>{{ __('expense_maincategory') }} *</th> 
                    <th>{{ __('fine') }}</th> 
                    <th>{{ __('notes') }}</th>
                    <th></th>
                </tr>

                @if (isset($resource))
                @foreach($resource->details()->get() as $item)
                <tr>
                    <td>
                        <input type="hidden" name="id[]" value="{{ $item->id }}" > 
                        <input type="date" name="date_from[]" value="{{ $item->date_from }}" required="" class="form-control form-control-sm font-large" >
                    </td>
                    <td>
                        <input type="date" name="date_to[]" value="{{ $item->date_to }}" required="" class="form-control form-control-sm font-large" >
                    </td>
                    <td>
                        <input type="number" name="value[]" onkeyup="calculateSum()" value="{{ $item->value }}" required=""  class="form-control form-control-sm font-large value" >
                    </td> 
                    <td>
                        <input type="text" name="notes[]" value="{{ $item->notes }}" class="form-control form-control-sm font-large" > 
                    </td>
                </tr> 
                @endforeach
                @endif



            </table> 
            <br>
            <table class="table" >
                <tr>
                    <td><button type="button" class="btn btn-default fa fa-plus btn-sm" onclick="addRow()" ></button></td>
                </tr>
                <tr>
                    <td>
                        <b>{{ __('sum') }}</b>
                    </td>
                    <td>
                        <input type="text" 
                               readonly="" 
                               required=""
                               max="{{ $resource->value }}"
                               min="{{ $resource->value }}"
                               name="sum" class="form-control form-control-sm font-large sum" 
                               value="0" > 
                    </td>
                </tr>
            </table> 
            <br>
            <div class="w3-padding" >
                <center>
                    <a role="button" class="btn btn-default shadow" href="{{ route('plans.index') }}" data-dismiss="modal">{{ __('close') }}</a>
                    <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
                </center>
            </div> 

@section('more_scripts')

    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
<script>
    var html = $('.clone-row').html();

    function setExpense(element) {
        var input = $(element)
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .find('.expense_maincategory_ids');
        var values = []; 
         $(element).parent().parent().parent().parent().find('.checkbox-input').each(function(){
              
             if (this.checked) {
                 values.push($(this).attr('data-id'));
             }
        });
        console.log(values);
        input.val(values.toString()); 
    }

    function calculateSum() {
        var sum = 0;
        $('.value').each(function () {
            //
            console.log(this.value);
            if (this.value > 0)
                sum += parseFloat(this.value);
        });
        
        console.log(sum);
        $('.sum').val(sum);
    }

    function addRow() {
        var row = document.createElement("tr");
        //
        row.innerHTML = html;
        // 
        $("#installTable").append(row);
        $('.select2').select2();
        calculateSum();
    }

    function removeRow(button) {
        var tr = $(button).parent().parent();
        confirmMessage(function () {
            tr.remove();
            calculateSum();
        });
    }
 
    $(document).ready(function () {
        //convertAjax(document.getElementById('installForm'), null, false);
        
        formAjax(null, function(d){
            window.location.reload();
        });
        calculateSum();
        
        //convertAjax(document.getElementById('installForm'));
    });
</script>
@endsection

