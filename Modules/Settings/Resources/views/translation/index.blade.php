@extends('layouts.admin')

@php
    $links = [
        ['name' => __('home'), 'url' => url('/')],
        ['name' => __('translation'), 'active' => true], 
    ];
@endphp

@section('content')
 
@include('layouts.breadcrumb', ['links' => $links])
 
<div class="card"> 
    <div class="card-content">
        <div class="card-body" >
            <div class="table-responsive">
                
                    @csrf
                    {!! view('settings::translation.table') !!} 
               
            </div>
        </div>
    </div>
</div>
@endsection
 
@section('more_scripts')
<script src="{{ url('/app-assets/js/formajax.js') }}" ></script>
<script>
    
    function submitTrans(button) {
        var html = button.innerHTML;
        $(button).html('<i class="fa fa-spin fa-spinner" ></i>');
        $(button).attr('disabled', 'disabled');
        var data = [];
        $(".trans-row").each(function(){
            var object = {
                id: $(this).find(".id").val(),
                name_ar: $(this).find(".name_ar").val(),
                name_en: $(this).find(".name_en").val()
            };
            data.push(object);
        });
        console.log(data);
        $.post("{{ route('translationUpdate') }}", "_token={{ csrf_token() }}&data="+JSON.stringify(data), function(r){
            playSound("not2");
            if (r.status == 1) {
                iziToast.success({
                    title: r.message,
                    position: 'topRight'
                });
            } else { 
                iziToast.error({
                    title: r.message,
                    position: 'topRight'
                });
            }
            $(button).html(html);
            $(button).removeAttr('disabled');
        });
    }
    
    
    formAjax(true, function(data){
        
    });
</script>
@endsection