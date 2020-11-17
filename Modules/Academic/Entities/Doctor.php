<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\Level;

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
    
    protected $appends = [
        'can_delete', 'levels', 'level_names'
    ];
    
	public function getLevelNamesAttribute() { 
		$names = Level::whereIn('id', $this->doctorLevels()->pluck('level_id')->toArray())->pluck('name')->toArray();
        return implode(", ", $names);
	}
	
	public function getLevelsAttribute() { 
        return implode(", ", $this->doctorLevels()->pluck('level_id')->toArray());
	}
	
    public function getCanDeleteAttribute() {
        return true;
    }
    
    public function doctorLevels() {
        return $this->hasMany("Modules\Academic\Entities\DoctorLevel", 'doctor_id');
    }

}
