@extends('layouts.admin')
@section('title') {{ __('applications') }} @endsection

@section('content')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('application'), 'active' => true], 
];
@endphp

@include('layouts.breadcrumb', ['links' => $links])

<div class="card" >
    <div class="card-body" >
        <form  method="get" action="" >
            <div class="row" >

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="search_key">{{ __('search with application info') }}</label>
                            {!! Form::text('search_key',null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('search with application info')])!!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="academic_year_id">{{ __('academic_year') }}</label>
                            {!! Form::select('academic_year_id',Modules\Settings\Entities\AcademicYear::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' =>  __('all') ])!!}

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="level_id">{{ __('level') }}</label>
                            {!! Form::select('level_id',Modules\Settings\Entities\Level::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('all') ])!!}

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="qualification_types_id">{{ __('qualification_types') }}</label>
                            {!! Form::select('qualification_types_id',Modules\Settings\Entities\QualificationTypes::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('all')  ])!!}

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="nationality_id">{{ __('nationality') }}</label>
                            {!! Form::select('nationality_id',App\Nationality::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('all') ])!!}

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="nationality_id">{{ __('completed files') }}</label>
                            <select class= "custom-select" onchange="filter(this.value)" name='files'>
                                <option value="0"> {{ __('all') }}</option>
                                <option value="1"> {{ __('completed') }} </option>
                                <option value="2">{{ __('not completed') }}</option>
                            </select>
                        </div>
                    </div>
                </div>



                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button>
                    <a role="button" href="{{ route('qualification-types.index') }}" class="btn btn-danger waves-effect waves-light">{{ __('select all') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="box">
    <div class="box-header">
        <a role="button"  href="{{route('applications.create')}}" class="btn shadow waves-effect w3-indigo" >
            <i class="fa fa-plus" ></i> {{ __('create') }} 
        </a>
        <a role="button" onclick="$('.buttons-copy').click()"  href="#" class="btn shadow waves-effect w3-dark-gray" >
            <i class="fa fa-clipboard" ></i> {{ __('copy') }} 
        </a> 
        <a role="button" onclick="$('.buttons-csv').click()"  href="#" class="btn shadow waves-effect w3-green" >
            <i class="fa fa-file-excel-o" ></i> {{ __('excel') }} 
        </a> 
        <a role="button" onclick="$('.buttons-pdf').click()"  href="#" class="btn shadow waves-effect w3-red" >
            <i class="fa fa-file-pdf-o" ></i> {{ __('pdf') }} 
        </a> 
    </div>
    <div class="box-content">

        <div class="table-responsive">
        </div>
    </div>
</div>

@include('adminsion::applications.table')
<br>
<center>
    <div class="text-center w3-center shadow w3-round-xlarge w3-white w3-padding" >
        {!! $resources->links() !!}
    </div>
</center>

@endsection

@section('more_scripts')
<script src="{{ url('/js/jspdf.plugin.autotable.min.js') }}" ></script>
<script>
            function exportPdf() {
                var doc = new jsPDF('p', 'pt');
                var elem = document.getElementById("table");
                var res = doc.autoTableHtmlToJson(elem);
                doc.autoTable(res.columns, res.data);
                doc.save("applications.pdf");
            }

            $('#table').DataTable({
                "paging": false,
                dom: 'Bfrtip',
                "sorting": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
</script>
@endsection
