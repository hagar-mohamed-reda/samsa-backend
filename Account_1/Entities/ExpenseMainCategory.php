<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseMainCategory extends Model
{
    protected $table = "account_expenses_maincategories";
    
    protected $fillable = [
        'name',
        'value',
        'notes',
        'priority',
        'store_id',
        'user_id',
        'academic_year_id',
        'level_id'
    ];
    
    public function user() {
        return $this->belongsTo('App\User', "user_id");
    }
    
    public function academicYear() {
        return $this->belongsTo('Modules\Settings\Entities\AcademicYear', "academic_year_id");
    }
    
    public function level() {
        return $this->belongsTo('Modules\Settings\Entities\Level', "level_id");
    }
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', "store_id");
    }
    
    public function expenseSubCategories() {
        return $this->hasMany("Modules\Account\Entities\ExpenseSubCategory", 'expenses_maincategory_id');
    }
    
}
