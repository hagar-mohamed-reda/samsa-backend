<?php

namespace Modules\Settings\Entities;
use Modules\Settings\Entities\Qualification;
use Illuminate\Database\Eloquent\Model;

class QualificationType extends Model
{
    protected $table = 'qualification_types';
    protected $fillable = ['qualification_id', 'name', 'grade', 'level_id', 'academic_year_id', 'percentage', 'notes'];

    protected $hidden = ['created_at', 'updated_at'];

    public function qualification()
    {
        return $this->belongsTo('Modules\Settings\Entities\Qualification','qualification_id');
    }

    public function level()
    {
        return $this->belongsTo('Modules\Divisions\Entities\Level','level_id');
    }
    
    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear','academic_year_id');
    }
    public function applications(){
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'qualification_types_id');
    }
    public function students(){
        return $this->hasMany('Modules\Student\Entities\Student', 'qualification_types_id');
    }
}
