<?php

namespace Modules\Adminsion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Adminsion\Entities\Application;
use Modules\Adminsion\Http\Controllers\validation\ApplicationValidation;
use Modules\Adminsion\Http\Controllers\ApplicationStoreController;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Level;
use Modules\Settings\Entities\Qualification;
use Modules\Settings\Entities\QualificationTypes;

class ApplicationController extends Controller {

    /**
     * Display a listing of the resource.
     * 
     * @return Response String
     */
    public function index() {
        $fillable = (new Application)->fillable;
        $query = Application::query();

        if (request()->search_key) {
            foreach ($fillable as $field)
                $query->orWhere($field, "%" . request()->search_key . "%");
        }

        if (request()->nationality_id > 0)
            $query->where('nationality_id', request()->nationality_id);

        if (request()->academic_year_id > 0)
            $query->where('academic_year_id', request()->academic_year_id);

        if (request()->level_id > 0)
            $query->where('level_id', request()->level_id);

        if (request()->qualification_types_id > 0)
            $query->where('qualification_types_id', request()->qualification_types_id);
//        dd(request()['files']);

        if (request()['files'] == 1)
            $query->where('level_id', '!=', null);
        if (request()['files'] == 2)
            $query->where('level_id', '=', null);

        $resources = $query->latest()->paginate(6);
        return view('adminsion::applications.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('adminsion::applications.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();

        // assign code of application
        $data['code'] = date("Y-m-d-H:i:s") . "-" . rand(11111, 99999);
        $data['writen_by'] = Auth::user()->id;

        // application validator
        $applicationValidator = new ApplicationValidation();

        // application store
        $applicationStore = new ApplicationStoreController();

        try {
            // validate on request input
            if ($applicationValidator->validateOnRequest($request)['status'] == 0) {
                return responseJson(0, $applicationValidator->validateOnRequest($request)['message']);
            }
            // validate on application required inputs
            if ($applicationValidator->validateOnApplicationRequired($request)['status'] == 0) {
                return responseJson(0, $applicationValidator->validateOnApplicationRequired($request)['message']);
            }
            // validate o on application required docuements
            if ($applicationValidator->validateOnRegisterationStatusDocument($request)['status'] == 0) {
                return responseJson(0, $applicationValidator->validateOnRegisterationStatusDocument($request)['message']);
            }
            //get qualification data 
            $qualification = Qualification::find($request->qualification_id);

            $qualificationType = QualificationTypes::find($request->qualification_types_id);

            $thanawyaDgree = Qualification::find(1);
            $thanawyaAmmaDgree = $thanawyaDgree->grade;

            if ($qualification->is_azhar == '1') {

                $totalGrade = $request->grade - $request->azhar_grade;

                $grade = ($totalGrade * $thanawyaAmmaDgree) / $qualificationType->grade;
                if ($grade >= $qualificationType->$grade) {
                    $data['level_id'] = $qualificationType->level_id;
                }else{
                    $data['level_id'] = '';
                }
            } else {
                if ($request->grade >= $qualificationType->grade) {
                    $data['level_id'] = $qualificationType->level_id;
                }else{
                    $data['level_id'] = '';
                }
            }
//            dd($data);

            // store application data
            $application = Application::create($data);
            // upload personal image 
            uploadImg($request->file('personal_photo'), Application::$FOLDER_PREFIX . $application->id, function($filename) use ($application) {
                $application->update([
                    'personal_photo' => Application::$FOLDER_PREFIX . $application->id . "/" . $filename
                ]);
            });

            // upload files
            $applicationStore->uploadFiles($request, $application);

            notfy(__('new application'), __('new application') . $application->name, 'fa fa-file-o');
            if ($application->level_id !='') {
                $level = Level::find($application->level_id);
                return responseJson(1, __('process has been success') . ' ' . __('student enrolled in level') . ' ' . $level->name);
            } else {
                return responseJson(1, __('process has been success'));
            }
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        $resource = Application::find($id);
        return view('adminsion::applications.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $application = Application::find($id);
        return view('adminsion::applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();

        $application = Application::find($id);

        // assign code of application
        $data['code'] = date("Y-m-d-H:i:s") . "-" . rand(11111, 99999);

        // application validator
        $applicationValidator = new ApplicationValidation();

        // application store
        $applicationStore = new ApplicationStoreController();

        try {

            // validate on request input
            if ($applicationValidator->validateOnRequest($request)['status'] == 0) {
                return responseJson(0, $applicationValidator->validateOnRequest($request)['message']);
            }

            // validate on application required inputs
            if ($applicationValidator->validateOnApplicationRequired($request)['status'] == 0) {
                return responseJson(0, $applicationValidator->validateOnApplicationRequired($request)['message']);
            }

            // validate o on application required docuements
//            if ($applicationValidator->validateOnRegisterationStatusDocument($request)['status'] == 0) {
//                return responseJson(0, $applicationValidator->validateOnRegisterationStatusDocument($request)['message']);
//            }
            // store application data

            $application->update($data);

            // upload personal image 
            uploadImg($request->file('personal_photo'), Application::$FOLDER_PREFIX . $application->id, function($filename) use ($application) {
                $application->update([
                    'personal_photo' => Application::$FOLDER_PREFIX . $application->id . "/" . $filename
                ]);
            });

            // upload files
            $files = $applicationStore->uploadFiles($request, $application);
            notfy(__('new application'), __('new application') . $application->name, 'fa fa-file-o');
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('process has been success'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        $application = Application::find($id);
        try {
            $application->delete();
            notify()->success(__('process has been success'), "", "bottomLeft");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('required_documents.index');
    }

}
