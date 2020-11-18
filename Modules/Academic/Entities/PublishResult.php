<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class PublishResult extends Model
{
    // table of bank
    protected $table = "academic_publish_result";
    
    protected $fillable = [ 
		'user_id',
		'academic_year_id',
		'term_id',
		'level_id',
		'date',
    ];
      
     
}
