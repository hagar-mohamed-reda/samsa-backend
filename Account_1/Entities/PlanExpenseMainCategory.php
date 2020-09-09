<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class PlanExpenseMainCategory extends Model
{
    protected $table = "account_plan_expense_maincategories";
    
    protected $fillable = [
        'plan_detail_id',
        'expense_maincategory_id'
    ];
     
    public function planDetail() {
        return $this->belongsTo('Modules\Account\Entities\PlanDetail', "plan_detail_id");
    }
    
    public function expenseMaincategory() {
        return $this->belongsTo('Modules\Account\Entities\ExpenseMaincategory', "expense_maincategory_id");
    }
      
}
