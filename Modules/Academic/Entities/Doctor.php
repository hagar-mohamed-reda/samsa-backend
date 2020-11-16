<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model {

    // table of bank
    protected $table = "academic_doctors";
    protected $fillable = [
        'name',
        'phone',
        'username',
        'password',
        'email',
        'gender',
        'description',
        'active'
    ];

}
