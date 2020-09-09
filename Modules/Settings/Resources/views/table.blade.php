

<!-- Scroll - horizontal and vertical table -->
<section id="horizontal-vertical">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table" >
                                <thead>
                                <tr>
                                   <th scope="col">KEY</th>
                                    <th scope="col">Name in Arabic</th>
                                    <th scope="col">Name in English</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Translation::all() as $row)                                    <tr>
                                        <th scope="row">{!! $row->key !!}</th>
                                        <td>{!! $row->name_ar !!}</td>
                                        <td>{!! $row->name_en !!}</td>

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
        function Delete(id){
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "عند الحذف لا يمكن استرجاع البيانات",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم احذف'
            }).then((result) => {
                if (result.value) {
                    $(id).submit();
                }
            })
        }
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
