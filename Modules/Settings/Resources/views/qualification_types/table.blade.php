<table class="table table-bordered default-datatable" id="table" >
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col"> {{ __('qualification') }} </th>

            <th scope="col"> {{ __('qualification type') }}</th>
            <th scope="col"> {{ __('academic_year') }} </th>
            <th scope="col"> {{ __('grade') }} </th>
            <th scope="col"> {{ __('percentage') }} </th>
            <th scope="col"> {{ __('level') }} </th>
            <th scope="col">{{ __('notes') }}</th>
            <th scope="col"> </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($qualification_types as $row)
        <tr>
            <th scope="row">{!! $row->id !!}</th>
            <td>{!! $row->qualifications->name !!}</td>

            <td>{!! $row->name !!}</td>
            <td>{!! optional($row->academicYear)->name !!}</td>
            <td>{!! $row->grade !!}</td>
            <td>{!! $row->percentage !!}%</td>
            <td>{!! $row->level->name !!}</td>
            <td>{!! $row->notes !!}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">

                    @permission('qualification-types_update')
                    <a href="{{route('qualification-types.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endpermission

                    @permission('qualification-types_delete')
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endpermission

                    <form id="deleteForm{{$row->id}}" action="{{route('qualification-types.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
