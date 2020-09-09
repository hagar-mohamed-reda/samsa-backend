@extends('layouts.admin')
@section('title')   @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('installment'), 'url' => url('/academic-years')],
['name' => __('install'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

<table class="hidden" >
    <tr class="hidden clone-row" >
        <td>
            <input type="hidden" name="id[]" value="0" > 
            <input type="date" name="date_from[]" min="{{ $resource->date_from }}" max="{{ $resource->date_to }}" required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="date" name="date_to[]" min="{{ $resource->date_from }}" max="{{ $resource->date_to }}" required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="value[]" onkeyup="calculateSum()" required=""  class="form-control form-control-sm font-large value" >
        </td>  
        <td>
            <input type="text" name="notes[]" class="form-control form-control-sm font-large" > 
        </td>
        <td>
            <button type="button" class="btn w3-red fa fa-trash btn-sm" onclick="removeRow(this)" ></button>
        </td>
    </tr> 
</table>
<div class="box shadow install-container" >
    <form method="post" action="{{ route('installments.storeInstall', $resource->id) }}" id="installForm" class="form" >
        @csrf
        <input type="hidden" name="user_id" value="{{ $resource->user_id }}" >
        <input type="hidden" name="installment_id" value="{{ $resource->id }}" >
        <input type="hidden" name="student_id" value="{{ $resource->student_id }}" >
        <input type="hidden" name="type" value="sub" >
        <div class="box-header" >

        </div>

        <div class="box-body" >
            <table class="table" >
                <tr>
                    <th class=" " >{{ __('date_from') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ $resource->date_from }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('date_to') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ $resource->date_to }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('value') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ $resource->remaining }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('student') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ optional($resource->student)->name }}" > 
                    </td>
                </tr>
                <tr>
                    <th class=" " >{{ __('user') }}</th>
                    <td>
                        <input type="text" readonly="" class="form-control form-control-sm font-large" value="{{ optional($resource->user)->name }}" > 
                    </td>
                </tr>
            </table>
            <br>

            <table class="table table-border" id="installTable" >
                <tr class="w3-light-gray" >
                    <th>{{ __('date_from') }} *</th>
                    <th>{{ __('date_to') }} *</th>
                    <th>{{ __('value') }} *</th> 
                    <th>{{ __('notes') }}</th>
                    <th></th>
                </tr>

                @if (isset($resource))
                @foreach($resource->installments()->get() as $item)
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
                    <a role="button" class="btn btn-default shadow" href="{{ route('installments.index') }}" data-dismiss="modal">{{ __('close') }}</a>
                    <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
                </center>
            </div>
        </div>
    </form>
</div> 
@endsection

@section('more_scripts')

    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
<script>
    var html = $('.clone-row').html();

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
        convertAjax(document.getElementById('installForm'), null, false);
        calculateSum();
        //convertAjax(document.getElementById('installForm'));
    });
</script>
@endsection

