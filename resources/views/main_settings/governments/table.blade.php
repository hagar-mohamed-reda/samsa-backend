
<table class="table table-bordered default-datatable" id="table" >
    <thead>
    <tr>
        <th> ID </th>
        <th> {{ __('government') }} </th>
        <th> {{ __('country') }} </th>
        <th> {{ __('notes') }}</th>
        <th> </th>
    </tr>
    </thead>
    <tbody>
    @foreach($governments as $row)
    <tr>
        <td>{!! $row->id !!}</td>
        <td>{!! $row->name !!}</td>
        <td>{!! $row->country->name  !!}</td>
        <td>{!! $row->notes !!}</td>
        <td>
            <div class="btn-group" role="group" aria-label="Basic example">
                @permission('governments_update')

                <a href="{{route('governments.edit', $row->id)}}">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                    </div>
                </a>
                @endpermission
                @permission('governments_delete')
               @if(count($row->militartAreas) == 0 && count($row->cities)== 0 && count($row->students)== 0&& count($row->applications)== 0)
                <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                    </div>
                </a>
                @endpermission

                <form id="deleteForm{{$row->id}}" action="{{route('governments.destroy',$row->id)}}" method="post">
                    @method("DELETE")
                    @csrf
                </form>
                @endif
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
