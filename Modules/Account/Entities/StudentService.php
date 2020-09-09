<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentService extends Model
{
    protected $table = "account_student_services";
 
    protected $fillable = [
        'service_id',
        'student_id' 
    ];
    
    public function service() {
        return $this->belongsTo('Modules\Account\Entities\Service', 'service_id');
    }
    
    public function student() {
        return $this->belongsTo('Modules\Student\Entities\Student', 'student_id');
    }  
    
}
