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
        $applicationRequirments = ApplicationRequired::all();
        return view('adminsion::application_requirments.index', compact('applicationRequirments'));
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
    public function store(Request $request)
    {

        $requests = $request->except('_token');
        // dd($requests);
        foreach($requests as $index => $value){
            // dd($value);
            $saver = [
                'name' => $index,
                'required' => $value
            ];
            // dd($saver);
            $application = ApplicationRequired::where('name', $index)->first();
            $application->update( $saver);

        }
        notify()->success("تم تعديل الاعدادات بنجاح", "", "bottomLeft" );
        return redirect()->route('application-requirments.index');

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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('adminsion::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
