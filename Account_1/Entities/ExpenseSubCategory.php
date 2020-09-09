<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    protected $table = "account_expenses_subcategories";
    
    protected $fillable = [
        'name',
        'expenses_maincategory_id',
        'value',
        'notes',
        'priority',
        'store_id'
    ];
     
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', "store_id");
    }
    
    public function expenseMainCategory() {
        return $this->belongsTo('Modules\Account\Entities\ExpenseMainCategory', "expenses_maincategory_id");
    }
}
