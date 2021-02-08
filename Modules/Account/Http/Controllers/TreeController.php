<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Tree; 
use DB;

class TreeController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        //$resources = DB::table('account_trees')->get(['id', 'parent', 'icon', 'text']);
        $totalCol = 'select sum(value) from account_dailies where tree_id = account_trees.id ';
        
        if (request()->date_from && request()->date_to)
            $totalCol .= " and date between '" . request()->date_from . "' and '" . request()->date_to. "'";
        
        if (request()->store_id > 0) 
            $totalCol .= " and ( account_dailies.store_id = " . request()->store_id . ") ";
         
        $resources = DB::table('account_trees')->select(
                'id', 'text',
                DB::raw("($totalCol) as total")
                )->get()->toArray();
        return $resources;
    }
 
    /**
     * Tree a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function tree(Request $request) {
        $resource = null;
        try {   
            $data = $request->all();
            $resource = Tree::create($data); 
            watch(__('add tree ') . $resource->text, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $resource);
    }
  

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Tree $tree) {
        try {   
            $tree->update($request->all());
            watch(__('edit Tree ') . $tree->name, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $tree->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Tree $tree) { 
        try { 
            watch(__('remove Tree ') . $tree->name, "fa fa-trophy"); 
            $tree->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
