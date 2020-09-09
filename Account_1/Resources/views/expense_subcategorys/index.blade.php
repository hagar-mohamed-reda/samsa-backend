@extends('layouts.admin')


@section('title') {{ __('expense_subcategorys') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('expense_subcategorys'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
<table class="hidden" >
    <tr class="hidden clone-row" >
        <td>
            <input type="hidden" name="id[]" value="0" >
            <input type="text" name="name[]" required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="value[]" required="" class="form-control form-control-sm font-large" >
        </td>
        <td>
            <input type="number" name="priority[]" required=""  class="form-control form-control-sm font-large" >
        </td>
        <td>
            <select name="store_id[]" required=""  class="form-control form-control-sm font-large" >
                <option></option>
                @foreach(\Modules\Account\Entities\Store::all() as $row)
                <option value="{{ $row->id }}" >{{ $row->name }} [{{ number_format($row->balance) }}]</option>
                @endforeach
            </select> 
        </td>
        <td>
            <input type="text" name="notes[]" class="form-control form-control-sm font-large" > 
        </td>
        <td>
            <button type="button" class="btn w3-red fa fa-trash btn-sm" onclick="var tr = $(this).parent().parent(); confirmMessage(function(){ tr.remove(); })" ></button>
        </td>
    </tr> 
</table>

@include('account::expense_subcategorys.filter')

@include('account::expense_subcategorys.table')

@include('account::expense_subcategorys.create', ['resource' => null])

@if (request()->resource_id)
@include('account::expense_subcategorys.edit', ['resource' => $resource])
@endif

    @php 
    $options = [
        ["name" => __("add"), "more" => "onclick=$('#createModal').modal('show')", "icon" => "fa fa-plus", "color" => "w3-teal"], 
        ["name" => __("filter"), "more" => "onclick=$('.filter').slideToggle(500)", "icon" => "fa fa-filter", "color" => "w3-purple"], 
        ["name" => __("excel"), "more" => "onclick=ExportToExcel('.table','banks')", "icon" => "fa fa-file-excel-o", "color" => "w3-green"], 
        ["name" => __("pdf"), "more" => "onclick=CreatePDFfromHTML('.table','banks')", "icon" => "fa fa-file-pdf-o", "color" => "w3-red"], 
        ["name" => __("print"), "more" => "onclick=printJS('table','html')", "icon" => "fa fa-print", "color" => "w3-dark-gray"], 
    ];
    @endphp
    @include('layouts.floatbutton', ['links' => $options])
@endsection

@section('more_scripts')
    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
<script>
    var html = $('.clone-row').html();

    function addRow(selector) { 
        var row = document.createElement("tr");
        //
        row.innerHTML = html;
        // 
        $("#" + selector).append(row);
    }

    $(document).ready(function () {
        formAjax(null, function(){
            window.location.reload();
        });
    });
</script>


@if (request()->resource_id)
<script>
    $('#editModal').modal('show');
</script>
@endif
@endsection
