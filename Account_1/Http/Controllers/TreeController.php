<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Tree; 

class TreeController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:trees_read'])->only('index');
        $this->middleware(['permission:trees_create'])->only('create');
        $this->middleware(['permission:trees_update'])->only('edit');
        $this->middleware(['permission:trees_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() { 
        return view('account::trees.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() { 
    }

    /**
     * Tree a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        // 
        $tree = Tree::create($request->item);
        return response(['done'=>true]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) { 
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) { 
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request) { 
        $tree = Tree::find($request->id);
        $tree->update(['text'=>$request->text]);
        return response(['done'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request) { 
        Tree::destroy($request->ids);
        return response(['done'=>true]);
    }
}
