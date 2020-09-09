<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryCourse extends Model
{
    protected $table = 'military_course';
    protected $fillable = ['name', 'notes','created_at', 'updated_at'];

    public function collections(){
        return $this->hasMany('Modules\Military\Entities\MilitaryCourseCollection', 'military_course_id');
    }
}
