
<!-- DataTable starts -->
<div class="table-responsive material-shadow w3-white w3-padding-0">
    <table class="table data-list- default-" id="table" >
        <thead>
            <tr class="w3-large w3-padding" >
                <th></th> 
                <th>{{ __('name') }}</th> 
                <th>{{ __('account_number') }}</th> 
                <th>{{ __('branche') }}</th> 
                <th>{{ __('init_balance') }}</th> 
                <th>{{ __('balance') }}</th>  
                <th>{{ __('notes') }}</th> 
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($resources as $row)
            <tr>
                <td>{!! $loop->iteration !!}</td>
                <td >{!! $row->name !!}</td>
                <td >{!! $row->account_number !!}</td>
                <td >{!! $row->branche !!}</td>
                <td >{!! number_format($row->init_balance) !!} EGP </td>
                <td >{!! number_format($row->balance) !!} EGP </td>  
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>
                 
                <td class="product-action btn-group">
                    <span class="action-edit">
                        <a href="{{route('banks.index')}}?resource_id={{ $row->id }}">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-edit"></i></div>
                            </div>
                        </a>
                    </span>
                    @if ($row->canDelete())
                    <span class="action-delete">
                        <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                            </div>
                        </a> 
                        <form id="deleteForm{{$row->id}}" action="{{route('banks.destroy',$row->id)}}" method="post">
                            @method("DELETE")
                            @csrf
                        </form>
                    </span>
                    @endif
                </td>
            </tr> 
        @endforeach
        </tbody>
    </table>
</div>
<!-- DataTable ends -->
 
