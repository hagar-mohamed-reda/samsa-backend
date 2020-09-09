<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryAreaSubmision extends Model
{
    protected $table = 'military_area_submision';
    protected $fillable = ['military_area_id', 'government_id', 'city_id', 'notes'];

    public function militaryArea(){
        return $this->belongsTo('Modules\Military\Entities\MilitaryAreas', 'military_area_id');
    }
    public function government(){
        return $this->belongsTo('App\Government', 'government_id');
    }
    public function city(){
        return $this->belongsTo('App\City', 'city_id');
    }
}
