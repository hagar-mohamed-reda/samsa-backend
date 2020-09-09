
<!-- DataTable starts -->
<div class="table-responsive material-shadow w3-white w3-padding-0">
    <table class="table data-list- default-" id="table" >
        <thead>
            <tr class="w3-large w3-padding" >
                <th></th> 
                <th>{{ __('name') }}</th> 
                <th>{{ __('value') }}</th> 
                <th>{{ __('priority') }}</th> 
                <th>{{ __('store') }}</th> 
                <th>{{ __('academic_year') }}</th>  
                <th>{{ __('level') }}</th>  
                <th>{{ __('user') }}</th>  
                <th>{{ __('notes') }}</th> 
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($resources as $row)
            <tr>
                <td>{!! $loop->iteration !!}</td>
                <td >{!! $row->name !!}</td>
                <td >{!! number_format($row->value) !!} EGP </td>
                <td >{!! $row->priority !!}</td>
                <td >{!! optional($row->store)->name !!}</td>
                <td >{!! optional($row->academicYear)->name !!}</td>
                <td >{!! optional($row->level)->name !!}</td>
                <td >{!! optional($row->user)->name !!}</td>
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>
                 
                <td class="product-action btn-group" style="width: 150px" >
                    <span class="action-edit">
                        <a href="{{route('expense_maincategorys.index')}}?resource_id={{ $row->id }}&action=show">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-desktop"></i></div>
                            </div>
                        </a>
                    </span>
                    <span class="action-edit">
                        <a href="{{route('expense_maincategorys.index')}}?resource_id={{ $row->id }}&action=edit">
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
                        <form id="deleteForm{{$row->id}}" action="{{route('expense_maincategorys.destroy',$row->id)}}" method="post">
                            @method("DELETE")
                            @csrf
                        </form>
                    </span>
                </td>
            </tr> 
        @endforeach
        </tbody>
    </table>
</div>
<!-- DataTable ends -->
 
