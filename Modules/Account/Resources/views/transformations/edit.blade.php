 
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('transformations'), 'url' => route('transformations.index')],
['name' => $resource->name, 'active' => true],
];
@endphp

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           {!! Form::model($resource, ['method'=>'put','route'=>['transformations.update',$resource->id],'files'=>'true'])!!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ __('edit transformation') }} {{ $resource->name }}
                </div>   
            </div>
            @include('layouts.breadcrumb', ['links' => $links, "shadow" => false])   
            <div class="modal-body"> 
                @include('account::transformations.form') 
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