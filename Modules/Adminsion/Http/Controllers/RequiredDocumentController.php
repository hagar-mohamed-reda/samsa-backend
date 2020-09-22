<?php

namespace Modules\Adminsion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Adminsion\Entities\RequiredDocument;
use Modules\Adminsion\Entities\StudentRequiredDocument;

class RequiredDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $requiredDocuments = RequiredDocument::latest()->get();
        return $requiredDocuments;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('adminsion::required_documents.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            RequiredDocument::create($request->all());   
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
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
        return view('adminsion::required_documents.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $requiredDocument = RequiredDocument::find($id);
        return view('adminsion::required_documents.edit', compact('requiredDocument'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $resource)
    { 
        $resource = RequiredDocument::find($resource);
        try {
            $resource->update($request->all()); 
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy( $resource)
    {  
        $resource = RequiredDocument::find($resource); 
        try {
            /*if ($requiredDocument->studentRequiredDocuments()->count() > 0)  {
                notify()->error(__('cant delete data depend on data'), "", "bottomLeft"); 
                return redirect()->route('required_documents.index');
            }*/ 
            $resource->delete(); 
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
