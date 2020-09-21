<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class RegistrationMethod extends Model
{
    protected $table = 'registration_methods';
    protected $fillable = ['name', 'notes'];
    protected $hidden = ['created_at', 'updated_at'];
    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'registration_method_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'registration_method_id');
    }
}
