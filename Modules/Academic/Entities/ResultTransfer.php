<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Academic\Entities\DegreeMap;

class ResultTransfer extends Model
{
    // table of bank
    protected $table = "academic_result_transfers";
    
    protected $fillable = [
  	'term_id',	
        'academic_year_id',	
        'user_id'
    ];
     
    
    public function academicYear() {
        return $this->belongsTo("Modules\Settings\Entities\AcademicYear", "academic_year_id");
    }
   
     
}
