<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\AccountSetting;
use DB;

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
    
    
    /**
     * give the student code
     * @param type $student
     */
    public static function codeStudent($student) {
        $year = AccountSetting::getCurrentAcademicYear();
        $lastCodeRow = self::where("academic_year_id", $year->id)
                ->where('level_id', optional($student)->level_id)
                ->first();
        $firstCode = optional($lastCodeRow)->code;
        
        $lastCode = DB::table('students')
                ->where("academic_years_id", $year->id)
                ->where('level_id', optional($student)->level_id)
                ->orderBy('code', 'DESC')
                ->first();
        
        $lastCode = optional($lastCode)->code;
        
        $code = $firstCode;
        
        if ($lastCode > 0) {
            $code = $lastCode + 1;
        }
        
        $student->code = $code;
        $student->update();
    }
}
