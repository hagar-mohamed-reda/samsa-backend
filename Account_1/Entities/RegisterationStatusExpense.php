<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class RegisterationStatusExpense extends Model
{
    protected $table = "account_registeration_status_expenses";
    
    protected $fillable = [
        'registeration_status_id',
        'expenses_maincategory_id'
    ];
    
    public function registerationStatus() {
        return $this->belongsTo('Modules\Settings\RegisterationStatus', "registeration_status_id");
    }
    
    public function expenseMainCategory() {
        return $this->belongsTo('Modules\Account\ExpenseMainCategory', "expenses_maincategory_id");
    }
}
