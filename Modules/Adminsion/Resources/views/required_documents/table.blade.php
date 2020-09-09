
<table class="table table-bordered default-datatable" id="table" >
    <thead>
    <tr>
        <th> # </th>
        <th> {{ __('name') }} </th>
        <th> {{ __('type') }} </th>
        <th> {{ __('notes') }} </th>
        <th> </th>
    </tr>
    </thead>
    <tbody>
    @foreach($requiredDocuments as $row)
    <tr>
        <td>{!! $loop->iteration !!}</td>
        <td>{!! $row->name !!}</td>
        <td>{!! __($row->type) !!}</td>
        <td>{!! $row->notes !!}</td>
        <td>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{route('required_documents.edit', $row->id)}}">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                    </div>
                </a>
                <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                    </div>
                </a>
                <form id="deleteForm{{$row->id}}" action="{{route('required_documents.destroy',$row->id)}}" method="post">
                    @method("DELETE")
                    @csrf
                </form>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
