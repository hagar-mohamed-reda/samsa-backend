<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryArea extends Model
{
    protected $table = 'military_areas';
    protected $fillable = ['name', 'government_id', 'notes'];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function government(){
        return $this->belongsTo('App\Government', 'government_id')->with(['country']);
    }
    public function militaryAreaSubmission(){
        return $this->hasMany('Modules\Military\Entities\MilitaryAreaSubmision', 'military_area_id');
    }
}
