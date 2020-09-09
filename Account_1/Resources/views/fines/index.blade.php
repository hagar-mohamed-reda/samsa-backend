@extends('layouts.admin')
@section('title') {{ __('fines') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('fines'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
 
    @include('account::fines.table', ['resource' => null])

    @include('account::fines.create')
    
    @if (request()->resource_id)
    @include('account::fines.edit', ['resource' => $resource])
    @endif
    
    
    @php 
        $options = [
            ["name" => __("add"), "more" => "onclick=$('#createModal').modal('show')", "icon" => "fa fa-plus", "color" => "w3-teal"], 
            ["name" => __("excel"), "more" => "onclick=ExportToExcel('.table','fines')", "icon" => "fa fa-file-excel-o", "color" => "w3-green"], 
            ["name" => __("pdf"), "more" => "onclick=CreatePDFfromHTML('.table','fines')", "icon" => "fa fa-file-pdf-o", "color" => "w3-red"], 
            ["name" => __("print"), "more" => "onclick=printJS('table','html')", "icon" => "fa fa-print", "color" => "w3-dark-gray"], 
        ];
    @endphp
    @include('layouts.floatbutton', ['links' => $options])
@endsection

@section('more_scripts')
    @if (request()->resource_id)
        <script>
        $('#editModal').modal('show');
        $('#editModal .balance_tr').remove();
        
        </script>
    @endif
@endsection
