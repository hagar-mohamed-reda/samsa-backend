<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;

class Student extends Model
{

    protected $table = "students";
    
    protected $appends = [
        'is_current_installed', 
        'is_old_installed', 
        'current_balance', 
        'old_balance', 
        'paid_value'
    ];
    
    public function getOldBalanceAttribute() {
        return $this->getStudentBalance()->getOldBalance();
    }
    
    public function getCurrentBalanceAttribute() {
        return $this->getStudentBalance()->getCurrentBalance();
    }
    
    public function getPaidValueAttribute() {
        return $this->getStudentBalance()->getPaidValue();
    }
    
    public function getStudentBalance() {
        return StudentBalance::find($this->id);
    }
     
    public function getIsCurrentInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'new')
                ->first();
        
        return $installment? true : false;
    }
     
    public function getIsOldInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'old')
                ->first();
        
        return $installment? true : false;
    }
    
    public function installments() {
        return $this->hasMany("Modules\Account\Entities\Installment", "student_id");
    }

}
