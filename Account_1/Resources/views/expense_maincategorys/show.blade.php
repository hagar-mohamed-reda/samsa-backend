 
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('expense_maincategorys'), 'url' => route('expense_maincategorys.index')],
['name' => $resource->name, 'active' => true],
];
@endphp

<div class="modal fade" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ $resource->name }}
                </div>   
            </div>
            @include('layouts.breadcrumb', ['links' => $links, "shadow" => false])   
            <div class="modal-body"> 
                <ul class="w3-ul" >
                    @foreach($resource->expenseSubCategories()->get() as $item)
                    <li>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <button class="  w3-circle {{ randColor() }}" style="width: 40px;height: 40px;margin: 5px" >{{ $loop->iteration }}</button>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $item->name }}</h4>
                                <table class="table" >
                                    <tr>
                                        <th>{{ __('value') }}</th>
                                        <td>{{ number_format($item->value, 2) }} EPG</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('priority') }}</th>
                                        <td>{{ $item->priority }}</td>
                                    </tr> 
                                    <tr>
                                        <th>{{ __('store') }}</th>
                                        <td>{{ optional($item->store)->name }}</td>
                                    </tr> 
                                    <tr>
                                        <th>{{ __('notes') }}</th>
                                        <td>{{ $item->notes }}</td>
                                    </tr> 
                                </table>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer text-center">
                <center>
                    <button type="button" class="btn btn-default shadow" data-dismiss="modal">{{ __('close') }}</button> 
                </center>
            </div>  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->