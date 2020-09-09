<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "account_payments";
    
    protected $fillable = [
        'student_id',
        'store_id',
        'date',
        'value',
        'user_id',
        'model_type', //[academic_year_expense, service, installment]
        'model_id' 
    ];
     
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', 'store_id');
    }
    
    public function student() {
        return $this->belongsTo('Modules\Student\Entities\Student', 'student_id');
    }
    
    public function model() {
        if ($this->type == 'academic_year_expense') {
            return $this->belongsTo('Modules\Account\Entities\AcademicYearExpenseDetail', 'model_id');
        }
        if ($this->type == 'service') {
            return $this->belongsTo('Modules\Account\Entities\Service', 'model_id');
        }
        
        return null;
    }
}
