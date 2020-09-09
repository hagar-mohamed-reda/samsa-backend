<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $table = 'nationalities';
    protected $fillable = ['name', 'notes'];
    public $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;
    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'nationality_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'nationality_id');
    }
}
