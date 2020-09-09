@extends('layouts.admin')
@section('title') {{ __('submissions status') }} @endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('submission status'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

<div class="card">
    <div class="card-header">
        @permission('registeration-status_create')
        <a class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" href="{{route('registeration-status.create')}}"><i class="ik ik-plus-circle"></i>{{ __('create') }}</a>
        @endpermission
    </div>
    <div class="card-content">
        <div class="table-responsive">
            @include('settings::registeration_status.table')
        </div>
    </div>
</div>

@if ($registerationStatus)
@include('settings::registeration_status.required_documents', ['registerationStatus' => $registerationStatus])
@endif
@endsection

@section('more_scripts')
@if ($registerationStatus)
<script>
    function searchDocument(key) {
        if (key.length < 0) 
            $('.document-list-item').show(500);
        else 
            $('.document-list-item').hide(500);
        $('.document-list-item').each(function(){
            if ($(this).text().includes(key)) {
                $(this).show();
            }
        });
    }
    $('#requiredDocumentModal').modal('show');
</script>
@endif
@endsection
