<?php

namespace Modules\Divisions\Entities;

use Illuminate\Database\Eloquent\Model;

class Level extends Model {

    protected $table = "levels";
    protected $fillable = ['name', 'notes', 'required_hour', 'required_course'];
    protected $hidden = ['created_at', 'updated_at'];

    public function department() {
        return $this->hasMany('Modules\Divisions\Entities\Department', 'level_id');
    }

    public function qualificationTypes() {
        return $this->hasMany('Modules\Settings\Entities\QualificationTypes', 'level_id');
    }

    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'level_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'level_id');
    }

}
