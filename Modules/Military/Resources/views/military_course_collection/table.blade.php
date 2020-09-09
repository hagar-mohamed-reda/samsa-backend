<table class="table table-bordered default-datatable" id="table" >
    <thead>
        <tr>
            <th> ID </th>
            <th>{{ __('academic year') }}</th>
            <th> {{ __('military course') }} </th>
            <th> {{ __('code') }} </th>
            <th> {{ __('starts in') }} </th>
            <th> {{ __('ends in') }} </th>
            <th>  </th>
            <th>  </th>
            <th>  </th>

        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($rows as $row)
        <tr>
            <td>{!! $row->id !!}</td>
            <td>{!! $row->academicYear->name !!}</td>
            <td>{!! $row->militartCourse->name !!}</td>
            <td>{!! $row->code !!}</td>
            <td>{!! $row->starts_in !!}</td>
            <td>{!! $row->ends_in !!}</td>

            <td>
                <div class="btn-group" role="group" aria-label="Basic example">

                    <a onmousedown="$('.military_course_collection_id').val('{{ $row->id }}')" data-toggle="modal" data-target="#studentModal">
                        <div class="w3-col">
                            <div class="fonticon-wrap"><i class="fa fa-user-plus"></i> {{ __('Add Students to military course') }} </div>
                        </div>
                    </a>
                </div>
            </td>
            <td>
               <div class="btn-group" role="group" aria-label="Basic example">
                    <a href = "{{ route('getCollectionStudents', $row->id) }}" > 
                         <div class="w3-col">
                            <div class="fonticon-wrap"><i class="fa fa-eye"></i>{{ __('Registred Students') }}</div>
                        </div>
                    </a>
               </div>
               <div class="btn-group" role="group" aria-label="Basic example">
                    <a href = "{{ route('getStudentsReport', $row->id) }}" > 
                         <div class="w3-col">
                            <div class="fonticon-wrap"><i class="fa fa-eye"></i>view report</div>
                        </div>
                    </a>
               </div>
            </td>
            <td>

               <div class="btn-group" role="group" aria-label="Basic example">

                    <a href="{{route('military-course-collection.edit', $row->id)}}">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                        </div>
                    </a>
                    <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                        </div>
                    </a>
                    <form id="deleteForm{{$row->id}}" action="{{route('military-course-collection.destroy',$row->id)}}" method="post">
                        @method("DELETE")
                        @csrf
                    </form>
                </div>
            </td>

        </tr>
        @endforeach
</table>


@include('military::military_course_collection.student_modal')

