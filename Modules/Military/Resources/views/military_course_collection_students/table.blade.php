 <table class="table table-border w3-bordered" id="table" >
    <thead>
        <tr class="w3-dark-gray" >
            <th scope="col" class="w3-large" >{{ __('ID') }}</th>
            <th class="w3-large" >{{ __('name') }}</th>
            <th class="w3-large">{{ __('national id') }}</th>
            <th class="w3-large">{{ __('code') }}</th>
            <th class="w3-large"> </th>
        </tr>
    </thead>
    <tbody>
    <input hidden type="text" name="military_course_collection_id" value="{{ $id }}"  >

    @foreach ($rows as $row )                                    
    <tr>
        <th scope="row" >
            {!! $row->id !!}
        </th>
        <th scope="row" >
            {!! $row->name !!}
        </th>
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
<br>
<div class="w3-center" >
    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" >{{ __('save') }}</button> 
    <!--</div>
    {!! Form::open(['method'=>'post','route'=>'military-course-students.store'])!!}
    
    <div class="">
        <table class="table table-border" id="table" >
            <thead>
            <tr>
                <th>{{ __('select all') }}</th>
                <th></th>
                <th>
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox"   value="false" onclick="checkAll()" >
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class=""></span>
                        </div>
                </th>
            </tr>
            </tr>
                <tr>
                    <th>{{ __('deselect all') }}</th>
                    <th></th>
                    <th>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox"   value="false" onclick="deCheckAll()" >
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class=""></span>
                            </div>
                    </th>
            </tr>
            </thead>
            <tbody>
                <input hidden type="text" name="military_course_collection_id" value="{{ $id }}"  >
                @foreach ($rows as $row )
    
                <tr>
                    <th scope="row"><label for="">{!! $row->name !!}</label></th>
                    <th scope="row"><label for="">{!! $row->national_id !!}</label></th>
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
    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('save') }}</button>
    {!! Form::close() !!}
    
    @section('more_scripts')
    <script>
        function checkAll() {
            $('.requirement-input').each(function(){
                this.checked = true;
            });
        }
    
        function deCheckAll() {
            $('.requirement-input').each(function(){
                this.checked = false;
            });
        }
    
        $("#table").DataTable({
            "paging": false,
            "sorting": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
            },
        });
    </script>
    @endsection
    
    -->
