<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Adminsion\Entities\Application;
use Modules\Adminsion\Entities\studentRequiredDocument;

class Student extends Model {

    /**
     * folder name of the application
     *
     * @var String
     */
    public static $FOLDER_PREFIX = "/uploads/students/";

    /**
     * folder name of the application
     *
     * @var String
     */ 
    protected $fillable = [
        'application_id',
        'constraint_status_id',
        'case_constraint_id',
        'email',
        'name',
        'academic_years_id',
        'code',
        'level_id',
        'division_id',
        'nationality_id',
        'gender',
        'register_join_date',
        'qualification_types_id',
        'qualification_date',
        'qualification_set_number',
        'language_1_id',
        'language_2_id',
        'city_id',
        'government_id',
        'country_id',
        'religion',
        'parent_job_id',
        'military_status_id',
        'military_area_id',
        'national_id',
        'password',
        'grade',
        'triple_number',
        'address',
        'birth_address',
        'phone_1',
        'national_id_date',
        'national_id_place',
        'registeration_date',
        'parent_name',
        'parent_national_id',
        'parent_address',
        'parent_phone',
        'relative_relation_id',
        'registration_status_id',
        'registration_method_id',
        'recommendation_card',
        'qualification_certificate',
        'birth_certificate',
        'personal_identification_photo',
        'personal_photo',
        'model_2_jund',
        'model_6_jund',
        'receipt_letter',
        'estimates_statement',
        'case_status',
        'degree_status',
        'egyptians_lab_speechs',
        'military_course_status',
        'qualification_id',
        'acceptance_code',
        'acceptance_date',
        'accepted_by'
    ];

    protected $appends = [
        'personal_photo_url' 
    ];
  
 
    public function getPersonalPhotoUrlAttribute() {
        $path = $this->personal_photo;

        return $path? url('/'). '' . $path : '/assets/img/avatar.png';
    }

    public function division() {
        return $this->belongsTo('Modules\Divisions\Entities\Division', 'division_id');
    }

    public function department() {
        return $this->belongsTo('Modules\Divisions\Entities\Department', 'department_id');
    }

    public function parentJob() {
        return $this->belongsTo('Modules\Settings\Entities\ParentJobs', 'parent_job_id');
    }

    public function language2() {
        return $this->belongsTo('App\Language', 'language_2_id');
    }

    public function language1() {
        return $this->belongsTo('App\Language', 'language_1_id');
    }

    public function city() {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function government() {
        return $this->belongsTo('App\Government', 'government_id');
    }

    public function country() {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function nationality() {
        return $this->belongsTo('App\Nationality', 'nationality_id');
    }

    public function nationalIdPlace() {
        return $this->belongsTo('App\Government', 'national_id_place');
    }

    public function militaryArea() {
        return $this->belongsTo('Modules\Military\Entities\MilitaryAreas', 'military_area_id');
    }

    public function militaryStatus() {
        return $this->belongsTo('Modules\Military\Entities\MilitaryStatus', 'military_status_id');
    }

    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear', 'academic_years_id');
    }

    public function registerationStatus() {
        return $this->belongsTo('Modules\Settings\Entities\RegisterationStatus', 'registration_status_id');
    }

    public function qualification() {
        return $this->belongsTo('Modules\Settings\Entities\Qualification', 'qualification_id');
    }

    public function QualificationTypes() {
        return $this->belongsTo('Modules\Settings\Entities\QualificationTypes', 'qualification_types_id');
    }

    public function level() {
        return $this->belongsTo('Modules\Divisions\Entities\Level', 'level_id');
    }

    public function studentRequiredDocument() {
        return $this->hasMany('Modules\Adminsion\Entities\StudentRequiredDocument', 'student_id')->with(['requiredDocument']);
    }

    public function user() {
        return $this->belongsTo('App\User', 'accepted_by');
    }

    public function case_constraint() {
        return $this->belongsTo('Modules\Settings\Entities\CaseConstraint', 'case_constraint_id');
    }

    public function constraint_status() {
        return $this->belongsTo('Modules\Settings\Entities\ConstraintStatus', 'constraint_status_id');
    }

}
