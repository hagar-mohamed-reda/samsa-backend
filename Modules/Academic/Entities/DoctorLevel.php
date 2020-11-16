<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class DoctorLevel extends Model {

    // table of bank
    protected $table = "academic_doctor_levels";
    protected $fillable = [
        'doctor_id', 'level_id', 'academic_year_id'
    ];

}
