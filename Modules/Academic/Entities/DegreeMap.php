<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class DegreeMap extends Model
{
    // table of bank
    protected $table = "academic_degree_map";
    
    protected $fillable = [
        'percent_from',  
        'percent_to',  
        'key', 
        'gpa', 
        'name'
    ];
      
     
    protected  $appends = [
        'can_delete'
    ];

    public function getCanDeleteAttribute(){
        $valid = true;
        if ($this->studentRegisters()->count() > 0)
            $valid = false;
        
        return $valid;
    }

   
    public function studentRegisters() {
        return $this->belongsTo("Modules\Academic\Entities\StudentRegisterCourse", "degree_map_id");
    }

}
