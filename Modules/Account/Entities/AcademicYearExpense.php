<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicYearExpense extends Model
{
    protected $table = "account_academic_year_expenses";
 
    protected $fillable = [
        'academic_year_id',
        'level_id',
        'division_id' 
    ];
     
    public function academic_year() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear', 'academic_year_id');
    }
    
    public function level() {
        return $this->belongsTo('Modules\Settings\Entities\Level', 'level_id');
    }
    
    public function division() {
        return $this->belongsTo('Modules\Settings\Entities\Division', 'division_id');
    } 
    
    public function details() {
        return $this->hasMany('Modules\Account\Entities\AcademicYearExpenseDetail', 'academic_year_expense_id')->with('store', 'term_id');
    }
}
