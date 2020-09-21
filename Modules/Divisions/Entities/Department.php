<?php

namespace Modules\Divisions\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table =  "departments";
    protected $fillable = ['name', 'level_id', 'notes'];
    protected $hidden = ['created_at', 'updated_at'];

    public function level(){
        return $this->belongsTo('Modules\Divisions\Entities\Level', 'level_id');
    }

    public function division(){
        return $this->hasMany('Modules\Divisions\Entities\Division', 'department_id');
    }
    
//    public function applications() {
//        return $this->hasMany('Modules\Adminsion\Entities\Application', 'department_id');
//    }
//
//    public function students() {
//        return $this->hasMany('Modules\Student\Entities\Student', 'department_id');
//    }
}
