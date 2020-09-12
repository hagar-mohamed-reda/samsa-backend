<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table = 'governments';
    protected $fillable = ['name', 'notes', 'country_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function cities()
    {
        return $this->hasMany('App\City','government_id');
    }

    public function militartAreas()
    {
        return $this->hasMany('Modules\Military\Entities\MilitaryAreas','government_id');
    }
    public function applications() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'country_id');
    }

    public function students() {
        return $this->hasMany('Modules\Student\Entities\Student', 'country_id');
    }
}
