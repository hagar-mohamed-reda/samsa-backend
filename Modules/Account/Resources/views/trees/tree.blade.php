<!--
<div class="panel panel-default">
    <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm btn-flat" onclick="createTree();"> اضافة</button>

        <button type="button" class="btn btn-warning btn-sm btn-flat" onclick="renameTree();">اعادة تسميه</button>

        <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="deleteTree();">حذف</button>
    </div>
</div>
-->
<br>
<div class="panel-body w3-display-container">
    <div class="jstree">
         
    </div>
    <input type="hidden" name="tree_id" class="tree_id" >
    <input type="hidden" name="type" class="type" >
    <div class="w3-display-topmiddle material-shadow context-menu w3-white" style="display: none;z-index: 99999999!important;min-width: 150px;position: fixed" >
        <ul class="w3-ul" >
            <li onclick="createTree();" class="w3-button w3-block" style="text-align: right!important" >
                <span class="fa fa-plus" style="margin-right: 5px;" ></span>
                <span>اضافة</span>
            </li>
            <li onclick="renameTree();" class="w3-button w3-block" style="text-align: right!important">
                <span class="fa fa-clipboard" style="margin-right: 5px;" ></span>
                <span>اعادة تسميه</span>
            </li>
            <li onclick="deleteTree();" class="w3-button w3-block" style="text-align: right!important">
                <span class="fa fa-trash" style="margin-right: 5px;" ></span>
                <span>حذف</span>
            </li>
        </ul>
    </div>
</div>


@section('more_scripts')
<script src="{{ url('/') }}/js/jstree.js" ></script>
<script>
    $('.jstree')[0].addEventListener('contextmenu', function(ev) {
        ev.preventDefault();
        console.log(ev);
        $('.context-menu').hide();
        $('.context-menu').css('left', ev.clientX + "px");
        $('.context-menu').css('top', (ev.clientY) + "px");
        $('.context-menu').slideDown(200);
        return false;
    }, false);
    
    $('.jstree').click(function(){
        $('.context-menu').slideUp(100);
        //
        var ref = $('.jstree').jstree(true),
        sel = ref.get_selected();
        console.log(sel);
        if (sel.length > 0)
        $('.tree_id').val(sel[0]);
    });
    
    $('.context-menu')[0].onmouseleave = function(){
        $('.context-menu').slideUp(100);
    };
    $('.context-menu')[0].onclick = function(){
        $('.context-menu').slideUp(100);
    };
    
  $('.jstree').on('select_node.jstree',function(e,node){
      console.log(node.selected[0] , 'selectecddd');
        var selectedNodeId = node.selected[0];
          var outs = $('.jstree').jstree(true).get_json('j1_2', {flat:true,no_state:true,no_id:false,no_children:false,no_li_attr:true,no_a_attr:true,no_data:true})        
          var outsids =  outs.map(function(node){ return node = node.id})
          var ins = $('.jstree').jstree(true).get_json('j1_1', {flat:true,no_state:true,no_id:false,no_children:false,no_li_attr:true,no_a_attr:true,no_data:true})                
          var insids =  ins.map(function(node){ return node = node.id})                      
          var type = '';
          if (outsids.includes(selectedNodeId) )   //masrofat 
          {
            
            type="out" 
          }
          else if (insids.includes(selectedNodeId))    
          { 
            type="in"
          }
     // $('[name=tree_id]').val(selectedNodeId)

      $('[name=type]').val(type)

    })
</script>
<script>
            function createTree() {
            var ref = $('.jstree').jstree(true),
                    sel = ref.get_selected();
                    if (!sel.length) { return false; }
            sel = sel[0];
                    sel = ref.create_node(sel, {"type":"default"});
                    if (sel) {
            ref.edit(sel);
            }
            };
            function renameTree() {
                    var ref = $('.jstree').jstree(true),
                    sel = ref.get_selected();
                    if (!sel.length) { return false; }
                    sel = sel[0];
                    ref.edit(sel);
            };
            function deleteTree() {
            var ref = $('.jstree').jstree(true),
                    sel = ref.get_selected();
                    if ($('.jstree').jstree(true).get_parent(sel) == '#')
                    return false;
                    if (!sel.length) { return false; }
            ref.delete_node(sel);
            };
            $(document).ready(function(){

    $('.jstree').jstree({
    "core" : {
    "animation" : 0,
            "check_callback" : true,
            'force_text' : true,
            "themes" : { "stripes" : true },
            'data' :{!! json_encode(DB::table('account_trees')->select(['id', 'type', 'icon', 'parent', 'text'])->get()) !!}
    },
            "types" : {
            "#" : { "max_children" : 1, "valid_children" : ["root"] },
                    "root" : { "icon" : "fa  fa-folder-o", "valid_children" : ["default"] },
                    "default" : { "valid_children" : ["default", "file"], "icon" : "fa  fa-folder-o" },
                    "file" : { "icon" : "fa fa-file-o", "valid_children" : [] }
            },
            "plugins" : [ "search", "state", "types", "wholerow", 'dnd']
    });
            $('.jstree').on('rename_node.jstree', function(e, node){
    var id = node['node']['id'];
            var text = node['text']
            $.ajax({
            type:'post',
                    url:"{{route('tree.update')}}",
                    data:{
                    id:id,
                            text:text
                    },
                    success:function(data){
                    console.log(data)
                    },
                    error:function(err)
                    {
                    console.log(err)
                    }
            })
    })
            $('.jstree').on('delete_node.jstree', function(e, node, parent){
    var id = node.node.id;
            var ch = $('.jstree').jstree(true).get_json(node.node, {flat:true, no_state:true, no_id:false, no_children:false, no_li_attr:true, no_a_attr:true, no_data:true})
            var ids = ch.map(function(node){ return node = node.id})

            $.ajax({
            type:'post',
                    url:"{{route('tree.destroy')}}",
                    data:{
                    ids:ids
                    },
                    success:function(data){
                    console.log(data)
                    },
                    error:function(err)
                    {
                    console.log(err)
                    }
            })
    })
            $('.jstree').on('create_node.jstree', function (e, data) {
    var t = $('.jstree').jstree(true).get_json(data.node, {flat:true, no_state:true, no_id:false, no_children:false, no_li_attr:true, no_a_attr:true, no_data:false})
            var item = t[0]
            $.ajax({
            type:'post',
                    url:"{{route('tree.store')}}",
                    data:{
                    item:item
                    },
                    success:function(data){
                    },
                    error:function(err)
                    {
                    console.log(err)
                    }
            })
    })


    });
</script>
@endsection