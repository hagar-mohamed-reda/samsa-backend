<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class PlanCaseConstraint extends Model
{
    protected $table = "account_plan_case_constraints";
    
    protected $fillable = [
        'plan_id',
        'case_constraint_id'
    ];
     
    public function plan() {
        return $this->belongsTo('Modules\Student\Entities\Plan', "plan_id");
    }
     
    public function caseContraint() {
        return $this->belongsTo('Modules\Account\Entities\CaseContraint', "case_constraint_id");
    }
      
}
