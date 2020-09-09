@extends('layouts.admin')

@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('report setting'), 'active' => true], 
];
@endphp

@section('content')

@include('layouts.breadcrumb', ['links' => $links])

<div class="card">
    <div class="card-header" style="padding-bottom: 1.5rem;">
        <h4 class="card-title">{{ __('letter_sending_to_institute') }} </h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" class=""><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse " style="">
        <div class="card-body">
    <form method="post" action="{{ route('reportUpdateSetting', 1) }}" >
                @csrf
                <div class="form-group" > 
                    <input type="hidden" name="name" value="letter_sending_to_institute" >
                    <input type="hidden" name="value" id="letter_sending_to_institute_value" >
                    <!-- The toolbar will be rendered in this container. -->
                    <div id="toolbar-container"></div>
                    <!--
                    <textarea id="letter_sending_to_institute" >{{ optional(Modules\Reports\Entities\ReportSetting::find(1))->value }}</textarea>
                    -->
                    <div id="letter_sending_to_institute" >{!! optional(Modules\Reports\Entities\ReportSetting::find(1))->value !!}</div>
                    
                </div>
                <div>
                    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light btn-sm" >{{ __('save') }}</button>
                </div>
    </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding-bottom: 1.5rem;">
        <h4 class="card-title">{{ __('letter_sending_from_institute') }} </h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" class=""><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse " style="">
        <div class="card-body">
    <form method="post" action="{{ route('reportUpdateSetting', 2) }}" >
                @csrf
                <div class="form-group" > 
                    <input type="hidden" name="name" value="letter_sending_from_institute" >
                    <input type="hidden" name="value" id="letter_sending_from_institute_value" >
                    <div id="toolbar-container2"></div>
                    <div id="letter_sending_from_institute" >{!! optional(Modules\Reports\Entities\ReportSetting::find(2))->value !!}</div>
                </div>
                <div>
                    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light btn-sm" >{{ __('save') }}</button>
                </div>
    </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding-bottom: 1.5rem;">
        <h4 class="card-title">{{ __('registration_certificate') }} </h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" class=""><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse " style="">
        <div class="card-body">
            <form method="post" action="{{ route('reportUpdateSetting', 4) }}" >
                @csrf
                <div class="form-group" > 
                    <input type="hidden" name="name" value="registration_certificate" >
                    <input type="hidden" name="value" id="registration_certificate_value" >
                    <div id="registration_certificate_tool"></div>
                    <div id="registration_certificate" >{!! optional(Modules\Reports\Entities\ReportSetting::find(4))->value !!}</div>
                </div>
                <div>
                    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light btn-sm" >{{ __('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding-bottom: 1.5rem;">
        <h4 class="card-title">{{ __('report header1') }} </h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse" class=""><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse " style="">
        <div class="card-body">
            <form method="post" action="{{ route('reportUpdateSetting', 3) }}" >
                @csrf
                <div class="form-group" > 
                    <input type="hidden" name="name" value="report_header1" >
                    <input type="hidden" name="value" id="report_header1_value" >
                    <div id="toolbar-container_report_header1"></div>
                    <div id="report_header1" >{!! optional(Modules\Reports\Entities\ReportSetting::find(3))->value !!}</div>
                </div>
                <div>
                    <button class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light btn-sm" >{{ __('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

 
@endsection

@section('more_scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/21.0.0/decoupled-document/ckeditor.js"></script>

<script>
    function setDocumentEditor(id, toolbar, input) {
        DecoupledEditor
            .create( document.querySelector( '#' + id ) )
            .then( editor => {
                const toolbarContainer = document.querySelector( '#' + toolbar );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            })
            .catch( error => {
                console.error( error );
            });
            
        $("#"+input)[0].form.onsubmit = function() {
            var html = $('#'+id).html();
            $('#'+input).val(html);
        };
    }
    
    setDocumentEditor('letter_sending_to_institute', 'toolbar-container', 'letter_sending_to_institute_value');
    setDocumentEditor('letter_sending_from_institute', 'toolbar-container2', 'letter_sending_from_institute_value');
    setDocumentEditor('report_header1', 'toolbar-container_report_header1', 'report_header1_value');
    setDocumentEditor('registration_certificate', 'registration_certificate_tool', 'registration_certificate_value');
  
</script> 
@endsection
 