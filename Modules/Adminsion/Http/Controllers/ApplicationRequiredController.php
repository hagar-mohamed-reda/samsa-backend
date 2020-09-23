<?php

namespace Modules\Adminsion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Adminsion\Entities\ApplicationRequired;

class ApplicationRequiredController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $resources = ApplicationRequired::all();
        return $resources;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('adminsion::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        // dd($requests);
        foreach($data as $item) {
            $applicationRequired = ApplicationRequired::where('id', $item->id);
            $applicationRequired->update($item);
        }
        return responseJson(1, __('done'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('adminsion::show');
    }
 

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
