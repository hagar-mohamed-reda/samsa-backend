<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentOldBalance extends Model
{
    protected $table = "account_student_old_balances";
    
    protected $fillable = [
        'student_id',
        'value',
        'notes'
    ];
     
    
}
