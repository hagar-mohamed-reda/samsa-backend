<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'qualifications';
    protected $fillable = ['name', 'is_azhar', 'grade', 'notes', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function qualification_types()
    {
        return $this->hasMany('Modules\Settings\Entities\QualificationTypes','qualification_id');
    }
}
