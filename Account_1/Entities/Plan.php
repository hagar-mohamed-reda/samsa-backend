<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "account_plans";
    
    protected $fillable = [
        'name',
        'expense_maincategory_id',
        'level_id',
        'value',
        'academic_year_id',
        'notes'	
    ];
    
    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear', "academic_year_id");
    }
    
    public function level() {
        return $this->belongsTo('Modules\Settings\Entities\Level', "level_id");
    }
    
    public function expenseMainCategory() {
        return $this->belongsTo('Modules\Account\Entities\ExpenseMainCategory', "expense_maincategory_id");
    }
     
    public function details() {
        return $this->hasMany('Modules\Account\Entities\PlanDetail', "plan_id");
    }
    
    public function caseContraints() {
        return $this->hasMany("Modules\Account\Entities\PlanCaseConstraint", "plan_id");
    }
    
    public function caseContraintModels() {
        $ids = $this->caseContraints()->pluck('case_constraint_id')->toArray();
        return CaseConstraint::whereIn('id', $ids);
    }
}
