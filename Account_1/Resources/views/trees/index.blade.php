@extends('layouts.admin')
@section('title')   @endsection

@section('custom-style')
<style>
    .type_section {
        display: none;
    }
</style>
@endsection

@section('content')
@php
$links = [
['name' => __('home'), 'url' => url('/')], 
['name' => __('tree'), 'active' => true],
];
@endphp
@include('layouts.breadcrumb', ['links' => $links])

<div class="box shadow install-container" > 
    <div class="box-body" >  
        <div class="panel panel-default">
            <div class="panel-body">
                @include('account::trees.tree')
            </div>
        </div>
        <div class="w3-padding" > 
        </div>
    </div> 
</div> 
@endsection


