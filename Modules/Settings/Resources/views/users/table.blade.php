<table class="table table-border default-datatable">
    <thead>
        <tr>
            <th> ID </th>
            <th> {{ __('image') }} </th>
            <th> {{ __('full name') }} </th>
            <th>{{ __('email') }}</th>
            <th> {{ __('role') }}</th>
            <th>  </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $row)
        <tr>
            <td>{!! $row->id !!}</td>
            {{-- {{ dd(url('/')) }} --}}
            <td><img class="round" style="width: 40px; height: 40px" src="{{url('/').'/public/'. $row->image}}" alt=""></td>
            <td>{!! $row->name !!}</td>
            <td>{!! $row->email !!}</td>
            <td>{!! __(optional($row->roles()->first())->name) !!}</td>
            <td>

                <div class="btn-group" role="group" aria-label="Basic example">
                    @if(auth()->user()->hasPermission('users_update'))
                    <a href="{{route('users.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endif
                    @permission('users_delete')
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endpermission
                    <form id="deleteForm{{$row->id}}" action="{{route('users.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> 