<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicSetting extends Model
{
    // table of bank
    protected $table = "academic_advising_settings";
    
    protected $fillable = [
  	 	'id', 'name',	'value'
    ];
      
     
}
