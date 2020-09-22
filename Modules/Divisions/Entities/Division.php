<?php

namespace Modules\Divisions\Entities;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

    protected $fillable = ['name', 'department_id', 'notes'];
    protected $hidden = ['created_at', 'updated_at'];
    public function department(){
        return $this->belongsTo('Modules\Divisions\Entities\Department', 'department_id')->with(['level']);
    }
    
    public function academicYear() {
        return $this->belongsTo("Modules\Settings\Entities\AcademicYear");
    }
    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'division_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'division_id');
    }
}
