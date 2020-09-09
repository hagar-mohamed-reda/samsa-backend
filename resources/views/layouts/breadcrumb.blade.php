@php
    $isShadow = true;
    
    if (isset($shadow))
        $isShadow = $shadow;
        
@endphp
<div class="w3-round {{ $isShadow? '' : ''  }}" style="margin: 0px!important;background-color: #f5f5f5;margin-bottom: 5px!important" >   
    <ol class="breadcrumb default-breadcrumb" style="margin: 0px!important" >
        @foreach($links as $link)
        <li class="breadcrumb-item {{ isset($link['active'])? 'active' : '' }}">
            <a class="w3-text-black" href="{{ isset($link['url'])? $link['url'] : '#' }}">{{ isset($link['name'])? $link['name'] : '' }}</a>
        </li>
        @endforeach  
    </ol> 
</div>   