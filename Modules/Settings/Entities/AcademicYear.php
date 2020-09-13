<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model {

    protected $table = 'academic_years';
    protected $fillable = ['name', 'start_date', 'end_date', 'notes', 'created_at', 'updated_at'];
    protected $hidden =['created_at', 'updated_at'];

    public function qualificationTypes() {
        return $this->hasMany('Modules\Settings\Entities\QualificationTypes', 'academic_year_id');
    }

    public function studentCodeSeries() {
        return $this->hasMany('Modules\Settings\Entities\StudentCodeSeries', 'academic_year_id');
    }

    public function militaryCourseCollection() {
        return $this->hasMany('Modules\Military\Entities\MilitaryCourseCollection', 'academic_year_id');
    }

    public function applications(){
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'academic_years_id');
    }
    public function students(){
        return $this->hasMany('Modules\Student\Entities\Student', 'academic_years_id');
    }
}
