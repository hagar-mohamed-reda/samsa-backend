<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicYearExpenseDetail extends Model
{
    protected $table = "account_academic_year_expenses_details";
 
    protected $fillable = [
        'name',
        'priorty',
        'value',
        'term_id',
        'store_id',
        'discount',
        'academic_year_expense_id'
    ];
     
  
    
    public function term() {
    return $this->belongsTo('Modules\Settings\Entities\Term', 'term_id');
    }
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', 'store_id');
    }
     
    
}
