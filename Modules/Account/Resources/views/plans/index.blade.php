@extends('layouts.admin')
@section('title') {{ __('plans') }} @endsection
@section('content')
 

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('plans'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

@include('account::plans.filter')


@include('account::plans.table')
  


@php 
$options = [
["name" => __("add"), "link" => route('plans.create'), "icon" => "fa fa-plus", "color" => "w3-teal"], 
["name" => __("filter"), "more" => "onclick=$('.filter').slideToggle(500)", "icon" => "fa fa-filter", "color" => "w3-purple"], 
["name" => __("excel"), "more" => "onclick=ExportToExcel('.table','banks')", "icon" => "fa fa-file-excel-o", "color" => "w3-green"], 
["name" => __("pdf"), "more" => "onclick=CreatePDFfromHTML('.table','banks')", "icon" => "fa fa-file-pdf-o", "color" => "w3-red"], 
["name" => __("print"), "more" => "onclick=printJS('table','html')", "icon" => "fa fa-print", "color" => "w3-dark-gray"], 
];
@endphp
@include('layouts.floatbutton', ['links' => $options])
@endsection

@section('more_scripts')
<script>
    $(document).ready(function () {
        $('#createModal input[name=date]').val('{{ date("Y-m-d") }}');
        
        $('.filter .select2').select2();
    });
</script>
 
@endsection
