<?php

namespace Modules\Divisions\Entities;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

    protected $fillable = ['name', 'department_id', 'notes'];
    
    public function department(){
        return $this->belongsTo('Modules\Divisions\Entities\Department', 'department_id');
    }
    
    public function academicYear() {
        return $this->belongsTo("Modules\Settings\Entities\AcademicYear");
    }
}
