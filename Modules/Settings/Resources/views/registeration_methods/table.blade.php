
<!-- Scroll - horizontal and vertical table -->
<section id="horizontal-vertical">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h4 class="card-title">Scroll - horizontal and vertical</h4> --}}
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        {{-- <p class="card-text">In this example you can see DataTables doing both horizontal and vertical scrolling at the same time. Note also that pagination is enabled in this example, and the scrolling accounts for this.</p> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table" >
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col"> {{ __('submission type') }} </th>
                                    <th scope="col">{{ __('notes') }}</th>
                                    <th scope="col">  </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registerationMethods as $row)
                                    <tr>
                                        <th scope="row">{!! $row->id !!}</th>
                                        <td>{!! $row->name !!}</td>
                                        <td>{!! $row->notes !!}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{route('registeration-methods.edit', $row->id)}}">
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="fonticon-wrap"><i class="fa fa-pencil"></i></div>
                                                    </div>
                                                </a>
                                                <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                                                    </div>
                                                </a>
                                                <form id="deleteForm{{$row->id}}" action="{{route('registeration-methods.destroy',$row->id)}}" method="post">
                                                    @method("DELETE")
                                                    @csrf
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('more_scripts')
    <script>
       
        $(document).ready(function() {
         var table = $('#table').DataTable({
            "pageLength": 10,
            dom: 'Bfrtip',
            "sorting": false,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
         });

         formAjax();

    });
    </script>
@endsection
