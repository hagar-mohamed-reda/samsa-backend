<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
    <!-- BEGIN: Head-->

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>المعهد العالى للعلوم الادارية/ @yield('title')</title>
        <link rel="apple-touch-icon" href="{{ url('/') }}/app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/') }}/app-assets/images/login/159101941365801.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors-rtl.min.css">
        <!-- END: Vendor CSS-->
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/main.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/colors.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/components.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/themes/semi-dark-layout.css">
        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors-rtl.min.css">
        <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/js/jquery/jquery.min.js">
        <!-- END: Vendor CSS-->
        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/plugins/forms/validation/form-validation.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css-rtl/custom-rtl.css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/assets/css/style-rtl.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- END: Custom CSS-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!-- print library -->
        <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">

        @include('layouts.custom_css')

        @yield('custom-style')
    </head>
    <!-- END: Head-->

    <!-- BEGIN: Body-->

    <body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
        @include('sweetalert::alert')

        <!-- BEGIN: Header-->
        @include('includes.nav')

        <!-- END: Header-->


        <!-- BEGIN: Main Menu-->
        @include('includes.sidebar')
        <!-- END: Main Menu-->
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">

                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- Dashboard Analytics Start -->
                    <section class="w3-center w3-modal-content" style="background-color: transparent!important" >
                         
                        @yield('breadcrumbs') 
                        <div class="card shadow w3-modal-content" style="border-radius: 0px!important" >
                            <div  id="printDiv" >
                            <div class="container" >
                                <div class="row">
                                    <div class="col-md-4" style="text-align: center">
                                        <span>المعهد العالى للعلوم الادارية</span>
                                        <br />
                                        <span>بنى سويف</span>
                                        <br />
                                        <span>{{ __('Military Education Administration') }}</span>
                                        <p>{{ __('Student Affairs Administration') }}</p>
                                    </div>
                                    <div class="col-md-4" style="text-align: center">
                                        <span style="border-bottom:1px solid #000;">كشف اسماء طلاب الدورة رقم {{ $collection->code }}</span>
                                        <br />
                                        <span style="border-bottom:1px solid #000;">
                                        {{ optional(Modules\Settings\Entities\TeamWork::find(4))->value }}
                                        </span>
                                   
                                        <span style="border-bottom:1px solid #000;"> {{__('starts in') }} {{ $collection->starts_in }}
                                         الى{{ $collection->ends_in }}</span> 
                                    </div>
                                    <div class="col-md-4" style="text-align: left">
                                        <img src="{{ url('/') }}/app-assets/images/login/159101941365801.png" style="width: 90px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                                <table class="table table-bordered default-datatable" id="table" >
                                    <thead> 
                                        <tr>
                                            <th> م </th>
                                            <th>{{ __('student name') }}</th>
                                            <th> {{ __('code') }} </th>
                                            <th> {{ __('national id') }} </th>
                                            <th> {{ __('institute name') }} </th>
                                            <th> {{ __('academic year') }} </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $row)
                                        <tr>
                                            <td>{!! $loop->iteration !!}</td>
                                            <td>{!! $row->student->name !!}</td>
                                            <td>{!! $row->student->code !!}</td>
                                            <td>{!! $row->student->national_id !!}</td>
                                            <td>{!! optional(\Modules\Settings\Entities\Setting::first())->institute_name !!}</td>
                                            <td>{!! optional($row->student->level)->name !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                            </div>
                                <div style="border-top: 1px dashed lightgray" class="w3-padding" >
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-4" style="text-align: right">
                                                <span style="font-size: 13px" >{{ __('signature') }}</span>
                                                <br />
                                                <span style="font-size: 13px" >{{ __('name') }}/</span>
                                                <br />
                                                <span style="font-size: 13px" >{{ __('course Supervisor') }}</span>
                                                <br />
                                                <span style="font-size: 13px" >{{ __('phone') }}/</span>
                                            </div>
                                            <div class="col-md-4" style="text-align: right">
                                                <span style="font-size: 13px">{{ __('signature') }}</span>
                                                <br />
                                                <span style="font-size: 13px">{{ __('name') }}/ {{ optional(Modules\Settings\Entities\TeamWork::find(3))->value }} </span> 
                                                <br />
                                                <span style="font-size: 13px">{{ __('Coordinator General of the Institute') }}</span>
                                                <br />
                                                <span style="font-size: 13px">{{ __('phone') }}/ </span>
                                            </div>
                                            <div class="col-md-4" style="text-align: right">
                                                <span style="font-size: 13px" >{{ __('signature') }}</span>
                                                <br />
                                                <span style="font-size: 13px" >{{ __('name') }}/ {{ optional(Modules\Settings\Entities\TeamWork::find(1))->value }} </span> 
                                                <br />
                                                <span style="font-size: 13px" >{{ __('institute_manager') }}</span>
                                                <br />
                                                <span style="font-size: 13px" >{{ __('phone') }}/ </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-footer w3-center w3-padding" >
                            
                                <button type="button"  onclick="printJS('printDiv', 'html')" class="btn-sm btn btn-relief-primary mr-1 mb-1 waves-effect waves-light shadow fa fa-print"> {{ __('print') }} </button>
                            </div>
                        </div>
                        <br>
                        <br>
                    </section>
                    <!-- Dashboard Analytics end -->

                </div>
            </div>
        </div>
        <!-- END: Content-->

        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        
        @include('includes.footer')
        <!-- END: Footer-->


        <!-- BEGIN: Vendor JS-->
        <script src="{{ url('/') }}/app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="{{ url('/') }}/app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Page Vendor JS-->
        <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.js"></script>
        <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
        <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
        <script src="../../../app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
        <script src="../../../app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Theme JS-->
        <script src="{{ url('/') }}/app-assets/js/core/app-menu.js"></script>
        <script src="{{ url('/') }}/app-assets/js/core/app.js"></script>
        <script src="{{ url('/') }}/app-assets/js/scripts/components.js"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="{{ url('/') }}/app-assets/js/scripts/forms/validation/form-validation.js"></script>
        <!-- END: Page JS-->

<!-- exports tools -->
<!-- print library -->
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="{{ url('/') }}/export/html-docx.js"></script>
      
        <!-- BEGIN: Page Vendor JS-->
        <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
        <script src="../../../app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Page JS-->
        <script src="../../../app-assets/js/scripts/datatables/datatable.js"></script>
        <!-- END: Page JS-->



        <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
        <script>
                     function datatable(id) {
                     $('#' + id).DataTable({
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
                     }
        </script>
        <script> 
                    
    //Create PDf from HTML...
    function CreatePDFfromHTML(selector, pdfName) {
        var HTML_Width = $(selector).width();
        var HTML_Height = $(selector).height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

        html2canvas($(selector)[0]).then(function (canvas) {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
            for (var i = 1; i <= totalPDFPages; i++) { 
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }
            pdf.save(pdfName + ".pdf");
            //$(selector).hide();
        });
    }
    
    function convertToDoc(selector, name)
    { 
        var converted = htmlDocx.asBlob($(selector).html());
        saveAs(converted, name+'.docx');
 
    }
 
    function ExportToExcel(selector, name){ 
       var html = $(selector).html();
       window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }
        </script>
        @yield('more_scripts')
        @include('vendor.lara-izitoast.toast')

    </body>
    <!-- END: Body-->

</html>
