
<div class="w3-display-bottomleft" style="z-index: 9999999;position: fixed!important;left: 50px!important" id="movediv" >

    <nav class="menu" style="position: relative!important" >
        <input type="checkbox" href="#" class="menu-open menu-open-options" name="menu-open" id="menu-open" onchange="this.checked? $('.menu-item-option').each(function(){ $(this).css('transform', $(this).attr('data-transform')) }) :  $('.menu-item-option').each(function(){ $(this).css('transform', 'translate3d(0, 0, 0)') });" />
        <label class="menu-open-button w3-indigo material-shadow" for="menu-open"> 
            <span class="lines line-1 w3-white"></span>
            <span class="lines line-2 w3-white"></span>
            <span class="lines line-3 w3-white"></span>
        </label>
        
        @foreach($links as $item)
        <a href="{{ isset($item['link'])? $item['link'] : '#' }}" 
           {{ isset($item['more'])? $item['more'] : '' }} 
            class="menu-item-option menu-item {{ isset($item['color'])? $item['color'] : randColor() }} material-shadow" data-transform="translate3d(0.08361px, -{{ ($loop->iteration * 70) + 15.99997 }}px, 0)" style="transform: translate3d(0, 0, 0);" >
            <i class="{{ isset($item['icon'])? $item['icon'] : '' }} w3-block w3-large"></i> 
            <span class="w3-tiny" >{{ isset($item['name'])? $item['name'] : '' }}</span>
        </a> 
        @endforeach
         
    </nav>

</div>