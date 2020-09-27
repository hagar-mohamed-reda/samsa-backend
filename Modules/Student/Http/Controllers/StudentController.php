<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Student;
use Modules\Student\Http\Requests\StudentRequest;
use Modules\Settings\Entities\QualificationTypes;
use Modules\Settings\Entities\StudentCodeSeries;
use Modules\Settings\Entities\AcademicYear;
use Modules\Adminsion\Entities\Application;
use Modules\Adminsion\Http\Controllers\validation\ApplicationValidation;
use Modules\Adminsion\Http\Controllers\ApplicationStoreController;
use Illuminate\Support\Facades\Auth;
use DB;

class StudentController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $fillable = (new Student)->fillable;
        $query = Student::with(['academicYear', 'qualification', 'level']);

        if (request()->search_key) {
            foreach ($fillable as $field)
                $query->orWhere($field, "%" . request()->search_key . "%");
        }

        if (request()->nationality_id > 0)
            $query->where('nationality_id', request()->nationality_id);

        if (request()->academic_years_id > 0)
            $query->where('academic_years_id', request()->academic_years_id);

        if (request()->level_id > 0)
            $query->where('level_id', request()->level_id);

        if (request()->qualification_types_id > 0)
            $query->where('qualification_types_id', request()->qualification_types_id);

        $resources = $query->latest()->paginate(10);

        return $resources;
    }

    /**
     * get
     */
    public function get($id) {
        $resource = Student::with(['academicYear', 'qualification', 'level', 'division', 'department', 'studentRequiredDocument'])->find($id);

        return $resource;
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('student::students.create');
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

        // application validator
        $applicationValidator = new ApplicationValidation();

        // application store
        $applicationStore = new ApplicationStoreController();



        $student_code = StudentCodeSeries::
                        where('academic_year_id', $request->academic_year_id)
                        ->where('level_id', $request->level_id)->first();
        $start_code = substr($student_code->code, 0, 5);
        $student_last_code = Student::where('code', 'LIKE', $start_code . '%')->pluck('code')->toArray();
        $data['code'] = max($student_last_code) + 1;



        if ($student_last_code != null) {
            $data['code'] = (string) (max($student_last_code) + 1);
        } else {
            $data['code'] = (string) $student_code->code;
        }


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

            // store application data
            $student = Student::create($data);

            // upload personal image 
            uploadImg($request->file('personal_photo'), Student::$FOLDER_PREFIX . $student->id, function($filename) use ($student) {
                $student->update([
                    'personal_photo' => Student::$FOLDER_PREFIX . $student->id . "/" . $filename
                ]);
            });

            // upload files
            $applicationStore->uploadStudentFiles($request, null, $student);

            notfy(__('new student'), __('new student') . $student->name, 'fa fa-user');
        } catch (\Exception $th) {
            return $th->getMessage();

            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('process has been success'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        $resource = Student::find($id);
        return view('student::students.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $student = Student::find($id);
        if (!$student) {
            notify()->error(__('data not found'), "", "bottomLeft");
            return redirect()->route('students.index');
        }

        return view('student::students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();

        $student = Student::find($id);
        $application = Application::find($student->application_id);

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

            // store application data
            $student->update($data);

            // upload personal image 
            uploadImg($request->file('personal_photo'), Student::$FOLDER_PREFIX . $student->id, function($filename) use ($student) {
                $student->update([
                    'personal_photo' => Student::$FOLDER_PREFIX . $student->id . "/" . $filename
                ]);
            });

            // upload files
            $applicationStore->uploadStudentFiles($request, $application, $student);

            notfy(__('new Student'), __('new Student') . $student->name, 'fa fa-user');
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage() . " from update student");
        }
        return responseJson(1, __('process has been success'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function saveToStudents(Request $request, $id) {
        $application = Application::find($id);

        $data = [
            'personal_photo' => $application->personal_photo,
            'application_id' => $application->id,
            'name' => $application->name,
            'level_id' => $application->level_id,
            'national_id' => $application->national_id,
            'gender' => $application->gender,
            'academic_years_id' => $application->academic_years_id,
            'registeration_date' => $application->registeration_date,
            'qualification_types_id' => $application->qualification_types_id,
            'qualification_id' => $application->qualification_id,
            'qualification_date' => $application->qualification_date,
            'password' => $application->password,
        ]; 
            $student_code = StudentCodeSeries::
                            where('academic_year_id', $application->academic_years_id)
                            ->where('level_id', $application->level_id)->first();

            $start_code = substr($student_code->code, 0, 5);

            
            if ($application->language_1_id != null)
                $data['language_1_id'] = $application->language_1_id;

            if ($application->language_2_id != null)
                $data['language_1_id'] = $application->language_2_id;

            if ($application->nationality_id != null)
                $data['nationality_id'] = $application->nationality_id;

            if ($application->qualification_set_number != null)
                $data['qualification_set_number'] = $application->qualification_set_number;

            if ($application->city_id != null)
                $data['city_id'] = $application->city_id;

            if ($application->government_id != null)
                $data['government_id'] = $application->government_id;

            if ($application->country_id != null)
                $data['country_id'] = $application->country_id;

            if ($application->religion != null)
                $data['religion'] = $application->religion;

            if ($application->military_status_id != null)
                $data['military_status_id'] = $application->military_status_id;

            if ($application->military_area_id != null)
                $data['military_area_id'] = $application->military_area_id;

            if ($application->grade != null)
                $data['grade'] = $application->grade;

            if ($application->triple_number != null)
                $data['triple_number'] = $application->triple_number;

            if ($application->address != null)
                $data['address'] = $application->address;

            if ($application->birth_address != null)
                $data['birth_address'] = $application->birth_address;

            if ($application->phone_1 != null)
                $data['phone_1'] = $application->phone_1;

            if ($application->registration_status_id != null)
                $data['registration_status_id'] = $application->registration_status_id;

            if ($application->registration_method_id != null)
                $data['registration_method_id'] = $application->registration_method_id;

            if ($application->national_id_date != null)
                $data['national_id_date'] = $application->national_id_date;

            if ($application->national_id_place != null)
                $data['national_id_place'] = $application->national_id_place;

            if ($application->parent_name != null)
                $data['parent_name'] = $application->parent_name;

            if ($application->parent_national_id != null)
                $data['parent_national_id'] = $application->parent_national_id;

            if ($application->parent_job_id != null)
                $data['parent_job_id'] = $application->parent_job_id;

            if ($application->parent_address != null)
                $data['parent_address'] = $application->parent_address;

            if ($application->parent_phone != null)
                $data['parent_phone'] = $application->parent_phone;

            if ($application->personal_photo != null)
                $data['personal_photo'] = $application->personal_photo;

            if ($application->acceptance_code != null)
                $data['acceptance_code'] = $application->acceptance_code;

            if ($application->acceptance_code != null)
                $data['acceptance_date'] = $application->acceptance_date;
            
            if ($application->email != null)
                $data['email'] = $application->email;
            
            if ($application->case_constraint_id != null)
                $data['case_constraint_id '] = $application->case_constraint_id ;
            
            if ($application->relative_relation_id != null)
                $data['relative_relation_id '] = $application->relative_relation_id ;
 

            $student_last_code = Student::where('code', 'LIKE', $start_code . '%')->pluck('code')->toArray();
            if ($student_last_code != null) {
                $data['code'] = (string) (max($student_last_code) + 1);
            } else {
                $data['code'] = (string) $student_code->code;
            }
 
         
        $data['application_id'] = $application->id;
        $student = Student::create($data);
        $application->status = 1;
        $application->save(); 

        DB::table('student_required_documents')
        ->where('student_id', $application->id)
        ->update([
            'student_id' => $student->id
        ]);
        notfy(__('add student'), __('add student ') . $student->name, 'fa fa-building-o');
        return responseJson(1, __('application enroll to student'));
    }

}
