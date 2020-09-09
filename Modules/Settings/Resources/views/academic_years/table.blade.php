 
<table class="table table-bordered default-datatable" id="table" >
    <thead>
        <tr>
            <th scope="col">#</th>
            <th>{{ __('academic year') }}</th>
            <th> {{ __('starts in') }}</th>
            <th> {{ __('ends in ') }} </th>
            <th scope="col"> {{ __('notes') }}</th>
            <th scope="col"> </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($academic_years as $row)
        <tr>
            <td>{!! $loop->iteration !!}</td>
            <td>{!! $row->name !!}</td>
            <td>{!! $row->start_date !!}</td>
            <td>{!! $row->end_date !!}</td>
            <td>{!! $row->notes !!}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    @permission('academic-years_update')
                    <a href="{{route('academic-years.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    @endpermission
                    @permission('academic-years_delete')
                
                    @if(
                    count($row->qualificationTypes) == 0 &&
                    count($row->studentCodeSeries) == 0 &&
                    count($row->militaryCourseCollection) == 0 &&
                    count($row->applications) == 0 &&
                    count($row->students) == 0
                    )
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    @endif
                    @endpermission
                    <form id="deleteForm{{$row->id}}" action="{{route('academic-years.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> 
