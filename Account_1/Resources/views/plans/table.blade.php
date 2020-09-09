
<!-- DataTable starts -->
<div class="table-responsive material-shadow w3-white w3-padding-0">
    <table class="table data-list- default-" id="table" >
        <thead> 
            <tr class="w3-large w3-padding" >
                <th></th> 
                <th>{{ __('name') }}</th> 
                <th>{{ __('value') }}</th> 
                <th>{{ __('expense_maincategory') }}</th> 
                <th>{{ __('level') }}</th> 
                <th>{{ __('academic_year') }}</th>  
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
                <td >{!! optional($row->expenseMainCategory)->name !!}</td>
                <td >{!! optional($row->level)->name !!}</td> 
                <td >{!! optional($row->academicYear)->name !!}</td> 
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>
                 
                <td class="product-action btn-group">
                    <span class="action-edit">
                        <a href="#" onclick="$('#showModal{{ $row->id }}').modal('show')" >
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="fonticon-wrap"><i class="fa fa-desktop"></i></div>
                            </div>
                        </a>
                    </span> 
                    <span class="action-edit">
                        <a href="{{route('plans.index')}}?resource_id={{ $row->id }}">
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
                        <form id="deleteForm{{$row->id}}" action="{{route('plans.destroy',$row->id)}}" method="post">
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
 

@foreach($resources as $row)
    @include('account::plans.show', ['resource' => $row])
@endforeach