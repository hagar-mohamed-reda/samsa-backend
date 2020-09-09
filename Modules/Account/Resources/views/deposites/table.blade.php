 
<!-- DataTable starts -->
<div class="table-responsive material-shadow w3-white w3-padding-0">
    <table class="table data-list- default-" id="table" >
        <thead>
            <tr class="" >
                <th></th> 
                <th>{{ __('date') }}</th> 
                <th>{{ __('bank_id') }}</th> 
                <th>{{ __('store_id') }}</th> 
                <th>{{ __('type') }}</th> 
                <th>{{ __('value') }}</th> 
                <th>{{ __('attachment') }}</th> 
                <th>{{ __('user_id') }}</th>  
                <th>{{ __('notes') }}</th> 
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($resources as $row)
            <tr>
                <td>{!! $loop->iteration !!}</td>
                <td >{!! $row->date !!}</td>
                <td >{!! optional($row->bank)->name !!}</td>
                <td >{!! optional($row->store)->name !!}</td> 
                <td >{!! __($row->type)!!}</td>
                <td >{!! number_format($row->value) !!} EGP </td> 
                <td >
                    @if ($row->attachment)
                    <a target="_blank" href="{!! $row->attachment_url !!}" class="w3-border-bottom w3-border-blue" >{!! __('attachment') !!}</a>
                    @endif
                </td>
                <td >{!! optional($row->user)->name !!}</td> 
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>
                 
                <td class="product-action btn-group">
                    <span class="action-edit">
                        <a href="#"  onclick="$('#DetailModal{{ $row->id }}').modal('show')" >
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-desktop"></i></div>
                            </div>
                        </a>
                    </span>
                    <!--
                    <span class="action-edit">
                        <a href="{{route('deposites.index')}}?resource_id={{ $row->id }}">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-edit"></i></div>
                            </div>
                        </a>
                    </span>
                    -->
                    <span class="action-delete hidden">
                        <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                            </div>
                        </a> 
                        <form id="deleteForm{{$row->id}}" action="{{route('deposites.destroy',$row->id)}}" method="post">
                            @method("DELETE")
                            @csrf
                        </form>
                    </span>
                </td>
            </tr> 
        @endforeach
        </tbody>
    </table>
    <br>
    
    <div>
        {!! $resources->links() !!}
    </div>
</div>
<!-- DataTable ends -->
 

@foreach($resources as $row) 
<div class="modal fade" id="DetailModal{{ $row->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ __('deposite details') }} 
                </div>   
            </div> 
            <div class="modal-body"> 
                <table class="table" >
                    <tr>
                        <th>{{ __('date') }}</th>
                        <td>{{ $row->date }}</td>
                    </tr> 
                    <tr>
                        <th>{{ __('type') }}</th>
                        <td>{{ __($row->type) }}</td>
                    </tr>
                    @if ($row->type == 'bank')
                    <tr>
                        <th>{{ __('bank') }}</th>
                        <td>{{ optional($row->bank)->name }}</td>
                    </tr>
                    @endif
                    @if ($row->type == 'store')
                    <tr>
                        <th>{{ __('store') }}</th>
                        <td>{{ optional($row->store)->name }}</td>
                    </tr>
                    @endif 
                    <tr>
                        <th>{{ __('user') }}</th>
                        <td>{{ optional($row->user)->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('notes') }}</th>
                        <td>{{  $row->notes  }}</td>
                    </tr>
                    @if ($row->attachment)
                    <tr>
                        <th>{{ __('attachment') }}</th>
                        <td >
                            <a target="_blank" href="{!! $row->attachment_url !!}" class="w3-border-bottom w3-border-blue"  >{!! __('attachment') !!}</a>
                           
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="modal-footer text-center">
                <center>
                    <button type="button" class="btn btn-default shadow"  onclick="$('#DetailModal{{ $row->id }}').modal('hide')" >{{ __('close') }}</button> 
                </center>
            </div>  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
@endforeach
