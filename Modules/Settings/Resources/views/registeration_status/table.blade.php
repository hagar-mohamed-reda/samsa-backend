<table class="table table-bordered default-datatable" id="table" >
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">{{ __('submission status') }} </th>
        <th scope="col"> {{ __('notes') }} </th>
        <th scope="col"> {{ __('required_documents') }} </th>
        <th scope="col">  </th>
    </tr>
    </thead>
    <tbody>
        @foreach ($registerationStatuses as $row)
        <tr>
            <th scope="row">{!! $row->id !!}</th>
            <td>{!! $row->name !!}</td>
            <td>{!! $row->notes !!}</td>
            <td>
                <ul >
                    <li class='w3-tiny' >
                    {!! implode("<li class='w3-tiny' >", $row->requiredDocuments()->pluck('name')->toArray()) !!}
                </ul>
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">

                    <a href="{{route('registeration-status.index')}}?registeration_status_id={{ $row->id }}">
                        <div class="w3-col">
                            <div class="fonticon-wrap"><i class="fa fa-newspaper-o"></i> {{ __('assign required documents') }} </div>
                        </div>
                    </a>
                    
                    @permission('registeration-status_update')
                    <a href="{{route('registeration-status.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endpermission

                    @permission('registeration-status_delete')
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endpermission

                    <form id="deleteForm{{$row->id}}" action="{{route('registeration-status.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
