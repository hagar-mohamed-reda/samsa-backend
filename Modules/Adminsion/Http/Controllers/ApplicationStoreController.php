<?php

namespace Modules\Adminsion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Adminsion\Entities\Application; 
use Modules\Adminsion\Entities\StudentRequiredDocument;
use Modules\Adminsion\Entities\RequiredDocument;
use Modules\Student\Entities\Student;

class ApplicationStoreController extends Controller {

    /**
     * upload file on server 
     * 
     * @param Request $request
     * @param Application $application
     */
    public function uploadFiles(Request $request, Application $application) {
        try { 
            $path = Application::$FOLDER_PREFIX . $application->id;
            foreach (RequiredDocument::all() as $item) { 

                
                //required_document_
                uploadImg($request->file('required_document_' . $item->id), $path, function($filename) use ($application, $item, $path) {
                    $resource = StudentRequiredDocument::where('required_document_id', $item->id)->where('student_id', $application->id)->first();

                    if ($resource) {
                        $file = public_path($resource->path);
                        // remove old file if exists
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    StudentRequiredDocument::create([
                        "required_document_id" => $item->id,
                        "student_id" => $application->id,
                        "path" => $path . "/" . $filename,
                    ]); 
                }); 
            }
        } catch (\Exception $th) { 
        }
    }

    public function uploadStudentFiles(Request $request, Student $student) {
        try { 
            $path = Student::$FOLDER_PREFIX . $student->id;
            foreach (RequiredDocument::all() as $item) { 
                //required_document_
                uploadImg($request->file('required_document_' . $item->id), $path, function($filename) use ($student, $item, $path) {
                    StudentRequiredDocument::create([
                        "required_document_id" => $item->id,
                        "student_id" => $student->id,
                        "path" => $path . "/" . $filename,
                    ]); 
                }); 
            }
        } catch (\Exception $th) { 
        }
    }



}
