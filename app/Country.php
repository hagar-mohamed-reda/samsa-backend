<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name', 'notes'];

    public function governments(){
        return $this->hasMany('App\Government', 'country_id');
    }
    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'country_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'country_id');
    }
}
