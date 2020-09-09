<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
    protected $table = "account_plan_details";
    
    protected $fillable = [
        'plan_id',
        'date_from',
        'date_to',
        'value',
        'fine_id',
        'notes'
    ];
     
    public function plan() {
        return $this->belongsTo('Modules\Student\Entities\Plan', "plan_id");
    }
     
    public function fine() {
        return $this->belongsTo('Modules\Account\Entities\Fine', "fine_id");
    }
    
    public function expenseMainCategorys() {
        $ids = PlanExpenseMainCategory::where('plan_detail_id', $this->id)->pluck('expense_maincategory_id')->toArray();
        return ExpenseMainCategory::whereIn('id', $ids);
    }
      
}
