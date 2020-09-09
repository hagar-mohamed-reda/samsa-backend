@extends('layouts.admin')
@section('title') {{ __('transformations') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('transformations'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

@include('account::transformations.filter')


@include('account::transformations.table')

@include('account::transformations.create')

@if (request()->resource_id)
@include('account::transformations.edit', ['resource' => $resource])
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
<script>
    $(document).ready(function () {
        $('#createModal input[name=date]').val('{{ date("Y-m-d") }}');
        
        $('.filter .select2').select2();
    });
</script>
@if (request()->resource_id)
<script>
    $('#editModal').modal('show');
</script>
@endif
@endsection
