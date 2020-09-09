 
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('payments'), 'url' => route('payments.index')],
['name' => __('add payment'), 'active' => true],
];
@endphp

<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method'=>'post','route'=>'payments.store', 'files'=>'true', 'class' => 'form'])!!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ __('add payment') }} 
                </div>   
            </div>
            @include('layouts.breadcrumb', ['links' => $links, "shadow" => false])   
            <div class="modal-body"> 
                @include('account::payments.form') 
            </div>
            <div class="modal-footer text-center">
                <center>
                    <button type="button" class="btn btn-default shadow" data-dismiss="modal">{{ __('close') }}</button>
                    <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
                </center>
            </div> 
            {!!Form::close()!!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->