<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryAreas extends Model
{
    protected $table = 'military_areas';
    protected $fillable = ['name', 'government_id', 'notes'];

    public function government(){
        return $this->belongsTo('App\Government', 'government_id');
    }
    public function militaryAreaSubmission(){
        return $this->hasMany('Modules\Military\Entities\MilitaryAreaSubmision', 'military_area_id');
    }
}
