<?php

namespace Modules\Military\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryCourseCollection;
use Modules\Military\Entities\StudentMilitaryCourse;
use Modules\Student\Entities\Student;

class StudentMilitaryCourseController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        dd(request()->military_course_collection_id);
        $rows = Student::where('gender', '1')->where('military_course_status', '!=', '0')->get();
        return view('military::military_course_collection_students.index', compact('rows'));
    }

    public function getStudents($id) {


        $rows = Student::where('gender', '1')->where('military_course_status', '!=', '1')->get();
        return view('military::military_course_collection_students.index', compact('rows', 'id'));
    }

    public function getCollectionStudents($id) {
        $collection = MilitaryCourseCollection::find($id);
        $students = $collection->militaryCourseCollectionStudent;


        return view('military::military_course_collection_students.collection_students', compact('collection', 'students'));
    }

    public function postCollectionStudents(Request $request) {
        $collections = StudentMilitaryCourse::where('military_course_collection_id', $request->military_course_collection_id)->get();
        try {
            if ($request->students != null) {
                foreach ($collections as $collection) {
                    $student = Student::where('id', $collection->student_id)->first();

                    if (!in_array($collection->student_id, $request->students)) {

                        $collection->status = '0';
                        $collection->save();

                        $student->military_course_status = '2';
                        $student->save();
                    } else {
                        $collection->status = '1';
                        $collection->save();
                        $student->military_course_status = '1';
                        $student->save();
                    }
                }
            } else {
                foreach ($collections as $collection) {
                    $collection->status = '0';
                    $collection->save();
                }
            }
        } catch (Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        notify()->success(__('process has been success'), "", "bottomLeft");
        notfy(__('the result has been approved successfully'), __('The result of the Military Course group is entered'), 'fa fa-building-o');
        return redirect()->route('getCollectionStudents', $request->military_course_collection_id);
    }

    public function delteteCollectionStudent($student_id) {
        $student_collection = StudentMilitaryCourse::where('student_id', $student_id)->first();
        $student = Student::where('id', $student_id)->first();
        $student->military_course_status = '0';
        $student->save();
        $student_collection->delete();
        notfy(__('the result has been approved successfully'), __('The result of the Military Course group is entered'), 'fa fa-building-o');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('military::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            if ($request->students != []) {
                foreach ($request->students as $id) {
                    $student = Student::find($id);
                    $student->military_course_status = 1;
                    $student->save();
                    $input['student_id'] = $student->id;
                    $input['military_course_collection_id'] = $request->military_course_collection_id;
                    $input['student_id'] = $student->id;
                    $input['status'] = 1;
                    $militaryStudent = StudentMilitaryCourse::create($input);
                }
                notfy(__('Students have been successfully added to the military course'), __('military course updated '), 'fa fa-users');
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            } else {
                notify()->warning(__('please choose students'), "", "bottomLeft");
            }
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
    public function show($id) {
        return view('military::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        return view('military::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function getStudentsReport($id) {
        $collection = MilitaryCourseCollection::find($id);

        if (!$collection) {
            notify()->warning(__('data not found'), "", "bottomLeft");

            return redirect()->route('military-course-collection.index');
        }
        $students = $collection->militaryCourseCollectionStudent;
        dd(count($students));
        if(count($students))
        return view('military::military_course_collection.student_report', compact('collection', 'students'));
    }

}
