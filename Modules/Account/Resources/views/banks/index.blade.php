@extends('layouts.admin')
@section('title') {{ __('banks') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('banks'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])
 
    @include('account::banks.table', ['resource' => null])

    @include('account::banks.create')
    
    @if (request()->resource_id)
    @include('account::banks.edit', ['resource' => $resource])
    @endif
    
    
    @php 
        $options = [
            ["name" => __("add"), "more" => "onclick=$('#createModal').modal('show')", "icon" => "fa fa-plus", "color" => "w3-teal"], 
            ["name" => __("excel"), "more" => "onclick=ExportToExcel('.table','banks')", "icon" => "fa fa-file-excel-o", "color" => "w3-green"], 
            ["name" => __("pdf"), "more" => "onclick=CreatePDFfromHTML('.table','banks')", "icon" => "fa fa-file-pdf-o", "color" => "w3-red"], 
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
