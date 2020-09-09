<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentCodeSeries extends Model
{
    
    protected $table = 'student_code_series';
    
    protected $fillable = [
        'academic_year_id',
        'level_id',
        'code'
    ];
    
    public function level() {
        return $this->belongsTo('Modules\Settings\Entities\Level');
    }
    
    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear');
    }
}
