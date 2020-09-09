 <table class="table table-bordered default-datatable" id="table" >
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col"> {{ __('academic_year') }}</th>
        <th scope="col"> {{ __('level') }}</th>
        <th scope="col"> {{ __('code') }}</th>
        <th scope="col"> </th>
    </tr>
    </thead>
    <tbody>
        @foreach ($resources as $row)
        <tr>
            <th scope="row">{!! $loop->iteration !!}</th>
            <td>{!! optional($row->academicYear)->name !!}</td>
            <td>{!! optional($row->level)->name !!}</td>
            <td>{!! $row->code !!}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">

                    @permission('student-code-series_update')
                    <a href="{{route('student-code-series.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endpermission

                    @permission('student-code-series_delete')
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endpermission

                    <form id="deleteForm{{$row->id}}" action="{{route('student-code-series.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
