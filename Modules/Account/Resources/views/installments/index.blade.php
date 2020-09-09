@extends('layouts.admin')
@section('title') {{ __('installments') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('installments'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

@include('account::installments.filter')
@include('account::installments.table', ['type' => 'main'])
<br>
{!! $resources->links() !!}

@include('account::installments.create')

@if (request()->resource_id)
@include('account::installments.edit', ['resource' => $resource])
@include('account::installments.show', ['resource' => $resource])
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
@if (request()->resource_id && request()->action == 'edit')
<script>
    $('#editModal').modal('show');
</script>
@endif
@if (request()->resource_id && request()->action == 'show')
<script>
    $('#showModal').modal('show');
</script>
@endif
@endsection
