<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryCourseCollection;
use Modules\Student\Entities\Student;

class MilitaryCourseCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $rows = MilitaryCourseCollection::orderBy('created_at', 'DESC')->get();
        $students = Student::where('gender', '1')->where('military_course_status', '!=', '1')->get();
        return view('military::military_course_collection.index', compact('rows', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('military::military_course_collection.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:military_course_collection,code',
            'starts_in' => 'required',
            'ends_in' => 'required',
            'military_course_id' => 'required',
        ]);
        try {

            $row = MilitaryCourseCollection::create($request->all());

            notfy(__('add military course collection'), __('add military course collection'), "fa fa-map-marker");
            notify()->success(__('process has been success'), "", "bottomLeft");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course-collection.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('military::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $row = MilitaryCourseCollection::find($id);
        if (!$row) {
            notify()->warning(__('These settings do not exist'), "", "bottomLeft" );
            return redirect()->route('military-course-collection.index');
        }
        return view('military::military_course_collection.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'starts_in' => 'required',
            'ends_in' => 'required',
            'military_course_id' => 'required',
        ]);
        try {
            $row = MilitaryCourseCollection::find($id);

            if (!$row) {
                notify()->warning(__('These settings do not exist'), "", "bottomLeft" );
            } else {
                $row->update($request->all());
                notfy(__('military course updated'), __('military course updated') . $row->name, 'fa fa-cog');
                notify()->success(__('The data has been modified successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course-collection.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $row = MilitaryCourseCollection::find($id);

        try {
            if (!$row) {
                notify()->warning(__('These settings do not exist'), "", "bottomLeft");
            } else {
                if(count($row->militaryCourseCollectionStudent) > 0){
                     notify()->error(__('this item can not be deleted'), "", "bottomLeft");
                }else{
                    $row->delete();
                    notify()->success(__('deleted successfully'), "", "bottomLeft");
                    notfy(__('military course deleted'), __('military course deleted') . $row->name, 'fa fa-cog');  
                }
                
            }

        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course-collection.index');
    }
}
