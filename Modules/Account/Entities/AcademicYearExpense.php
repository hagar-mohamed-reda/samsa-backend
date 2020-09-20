<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class AcademicYearExpense extends Model
{
    protected $table = "account_academic_year_expenses";
 
    protected $fillable = [
        'academic_year_id',
        'level_id',
        'division_id' 
    ];
     
    public function academic_year() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear', 'academic_year_id')->select(['id', 'name']);
    }
    
    public function level() {
        return $this->belongsTo('Modules\Divisions\Entities\Level', 'level_id')->select(['id', 'name']);
    }
    
    public function division() {
        return $this->belongsTo('Modules\Divisions\Entities\Division', 'division_id')->select(['id', 'name']);
    } 
    
    public function details() {
        return $this->hasMany('Modules\Account\Entities\AcademicYearExpenseDetail', 'academic_year_expense_id')->with('store', 'term');
    }

}
