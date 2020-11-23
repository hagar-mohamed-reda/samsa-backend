<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Adminsion\Entities\Application;
use Modules\Adminsion\Entities\studentRequiredDocument;
use DB;

class Student extends Model {

    /**
     * folder name of the application
     *
     * @var String
     */
    public static $FOLDER_PREFIX = "/uploads/students/";

    /**
     * table name of the db;
     *
     * @var type string
     */
    protected $table = 'students';

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
        'department_id',
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
        'accepted_by',
        'is_refund',
        'is_application',
        'writen_by',
        'application_code'
    ];
    protected $appends = [
        'personal_photo_url', 'availabe_cards'
    ];

    public function getAvailableCardsAttribute() {
        $cardTypes = DB::table('card_types')->pluck('id')->toArray();
        $cardExports = DB::table('card_exports')->where('student_id', $this->id)->pluck('payment_id')->toArray();
        $cardServices = DB::table('card_types')->pluck('service_id')->toArray();

        $payments = DB::table('account_payments')->where('student_id', $this->id)->where('model_type', 'service')->whereIn('model_id', $cardServices)->whereNotIn('id', $cardExports)->pluck('model_id')->toArray();

        $availableCards = DB::table('card_types')->whereIn('service_id', $payments)->pluck('id')->toArray();

        return $availableCards;
    }

    public function getPersonalPhotoUrlAttribute() {
        $path = $this->personal_photo;

        return $path ? url('/') . '' . $path : '/assets/img/avatar.png';
    }

    public function division() {
        return $this->belongsTo('Modules\Settings\Entities\Division', 'division_id');
    }

    public function department() {
        return $this->belongsTo('Modules\Settings\Entities\Department', 'department_id');
    }

    public function parentJob() {
        return $this->belongsTo('Modules\Settings\Entities\ParentJob', 'parent_job_id');
    }

    public function language2() {
        return $this->belongsTo('Modules\Settings\Entities\Language', 'language_2_id');
    }

    public function language1() {
        return $this->belongsTo('Modules\Settings\Entities\Language', 'language_1_id');
    }

    public function city() {
        return $this->belongsTo('Modules\Settings\Entities\City', 'city_id');
    }

    public function government() {
        return $this->belongsTo('Modules\Settings\Entities\Government', 'government_id');
    }

    public function country() {
        return $this->belongsTo('Modules\Settings\Entities\Country', 'country_id');
    }

    public function nationality() {
        return $this->belongsTo('Modules\Settings\Entities\Nationality', 'nationality_id');
    }

    public function nationalIdPlace() {
        return $this->belongsTo('Modules\Settings\Entities\Government', 'national_id_place');
    }

    public function militaryArea() {
        return $this->belongsTo('Modules\Military\Entities\MilitaryArea', 'military_area_id');
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
        return $this->belongsTo('Modules\Settings\Entities\QualificationType', 'qualification_types_id');
    }

    public function level() {
        return $this->belongsTo('Modules\Settings\Entities\Level', 'level_id');
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
        return $this->belongsTo('Modules\Settings\Entities\RegisterationStatus', 'registration_status_id');
    }

    public function card_exports() {
        return $this->belongsTo('Modules\Card\Entities\CardExport', 'student_id');
    }

}
