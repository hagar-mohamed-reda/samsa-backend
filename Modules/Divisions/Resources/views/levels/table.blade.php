<table class="table table-bordered default-datatable" id="table" >
    <thead>
        <tr>
            <th> ID </th>
            <th> {{ __('level name') }} </th>
            <th> {{ __('notes') }} </th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
        @foreach($levels as $row)
        <tr>
            <td>{!! $row->id !!}</td>
            <td>{!! $row->name !!}</td>
            <td>{!! $row->notes !!}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    @permission('levels_update')
                    <a href="{{route('levels.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endpermission
                    @permission('levels_delete')
                    @if(
                    $row->department->count() == 0 && 
                    $row->applications->count()==0 && 
                    $row->students->count()==0 &&
                    $row->qualificationTypes->count()==0
                    )
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endif
                    @endpermission
                    <form id="deleteForm{{$row->id}}" action="{{route('levels.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
