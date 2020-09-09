@extends('layouts.admin')
@section('title') {{ __('expense_maincategorys') }} @endsection
@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('expense_maincategorys'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

@include('account::expense_maincategorys.table')

    @include('account::expense_maincategorys.create')
    
    @if (request()->resource_id)
    @include('account::expense_maincategorys.edit', ['resource' => $resource])
    @include('account::expense_maincategorys.show', ['resource' => $resource])
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
    <script src="{{ url('/') }}/app-assets/js/formajax.js"></script>
    <script>
        $(document).ready(function(){
            formAjax(null, function(data){
                if (data.status == 1) {
                    window.location.reload();
                }
            });
        });
    </script>

    @if (request()->resource_id && request()->action=='edit')
        <script>
        $('#editModal').modal('show');
        </script>
    @endif
    @if (request()->resource_id && request()->action=='show')
        <script>
        $('#showModal').modal('show');
        </script>
    @endif
@endsection
