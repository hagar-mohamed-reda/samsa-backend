 
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
                    <a target="_blank" href="{!! $row->attachment_url !!}" class="w3-border-bottom w3-border-blue"  >{!! __('attachment') !!}</a>
                    @endif
                </td>
                <td >{!! optional($row->user)->name !!}</td> 
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>
                 
                <td class="product-action btn-group">
                    <span class="action-edit">
                        <a href="{{route('transformations.index')}}?resource_id={{ $row->id }}">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-edit"></i></div>
                            </div>
                        </a>
                    </span>
                    <span class="action-delete">
                        <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                            </div>
                        </a> 
                        <form id="deleteForm{{$row->id}}" action="{{route('transformations.destroy',$row->id)}}" method="post">
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
 
