@section('meta') 
<meta name="viewport" content="width=device-width, initial-scale=1">

@endsection
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">{{ __('please choose students') }}</h5>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="{{ __('search') }}" title="Type in a name">

            </div>
            {!! Form::open(['method'=>'post','route'=>'military-course-students.store'])!!}

            <div class="modal-body">

                <table class="table table-border w3-bordered" id="table" >
                    <thead>
                        <tr class="w3-dark-gray" >
                            <th scope="col" class="w3-large" >ID</th>
                            <th class="w3-large" >{{ __('name') }}</th>
                            <th class="w3-large">{{ __('national id') }}</th>
                            <th class="w3-large">{{ __('code') }}</th>
                            <th class="w3-large"> </th>
                        </tr>
                    </thead>
                    <tbody id="myUL">
                    <input hidden type="text" class="military_course_collection_id" name="military_course_collection_id" >

                    @foreach ($students as $row )                                    
                    <tr >
                        <td scope="row" >
                            {!! $row->id !!}
                        </td>
                        <td scope="row" >
                            {!! $row->name !!} 
                        </td>
                        <td>
                            {!! $row->national_id !!}
                        </td>
                        <td>
                            {!! $row->code !!}
                        </td>
                        <td>

                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox"
                                       class="requirement-input"
                                       value="{{ $row->id }} "
                                       name = "students[]">
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class=""></span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">{{ __('cancel') }}</button>
            </div>


            {!! Form::close() !!}

        </div>
    </div>
</div>
@section('more_scripts')

<script>
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("tr");
        for (i = 0; i < li.length; i++) {
            a = li[i];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>

@endsection