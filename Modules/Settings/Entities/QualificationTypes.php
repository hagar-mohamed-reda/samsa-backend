<?php

namespace Modules\Settings\Entities;
use Modules\Settings\Entities\Qualification;
use Illuminate\Database\Eloquent\Model;

class QualificationTypes extends Model
{
    protected $table = 'qualification_types';
    protected $fillable = ['qualification_id', 'name', 'grade', 'level_id', 'academic_year_id', 'percentage'];


    public function qualifications()
    {
        return $this->belongsTo('Modules\Settings\Entities\Qualification','qualification_id');
    }

    public function level()
    {
        return $this->belongsTo('Modules\Settings\Entities\Level','level_id');
    }
    
    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear','academic_year_id');
    }
}
