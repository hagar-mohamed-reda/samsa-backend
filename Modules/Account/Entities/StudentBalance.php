<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentBalance extends Student
{
    protected $table = "students";
    
   
    /**
     * calculate old balance of the student
     * @return float
     */
    public function getOldBalance() {
        // current academic year
        $academicYear = AccountSetting::getCurrentAcademicYear();
        
        // caculated balance
        $balance = 0;

        $studentOldBalance = StudentOldBalance::where('student_id', $this->id)->first();
        
        $balance += optional($studentOldBalance)->value;
        
        // check on payment value
        $balance -= Payment::where('student_id', $this->id)->whereIn('model_type', ['old_academic_year_expense'])->sum('value');
 
        // check if there is paid installment for old value
        $balance -= Installment::where('student_id', $this->id)->where('type', 'old')->where('paid', '1')->sum('value');
 

        return $balance;
    }
    
    public function getCurrentExpenses($term = null) {
        // current academic year
        $academicYear = AccountSetting::getCurrentAcademicYear(); 
        // current date
        $date = date('Y-m-d');
        

        








        
        // paid
        $paid = Payment::where('student_id', $this->id)->whereIn('model_type', ['academic_year_expense', 'installment'])->pluck("model_id")->toArray();

        $installment = Installment::where('student_id', $this->id)->where('date', '<=', $date)->where('paid', '0')->first();

        if ($this->is_current_installed) {
        }

        $query = AcademicYearExpenseDetail::join('account_academic_year_expenses', 'account_academic_year_expenses.id', '=', 'account_academic_year_expenses_details.academic_year_expense_id')
                ->where("academic_year_id", $academicYear->id)
                ->whereNotIn('account_academic_year_expenses_details.id', $paid);
        
        if ($term) 
            $query->where('term_id', $term);


        return $query;
    }
    
    /**
     * calculate current balance of the student
     * @return float
     */
    public function getCurrentBalance($term = null) {
        // caculated balance
        $balance = 0; 
        $query = $this->getCurrentExpenses($term);
        $currentAcademicYearExpenses = $query->sum('value');
        
        $balance += $currentAcademicYearExpenses; 
        return $balance;
    }


    public function getReadyInstallment($type) {
        $date = date('Y-m-d');
        $installment = Installment::where('student_id', $this->id)
            ->where('type', $type)
            ->where('paid', '0')
            ->whereDate('date', '<=', $date)
            ->first();

        return $installment;
    }
    
    /**
     * get paid value when student go to store
     * 
     * @return float
     */
    public function getPaidValue() {
        // current term
        $term = AccountSetting::getCurrentTerm();
        // old balance
        $oldBalance = $this->getOldBalance();
        // current balance of year
        $currentBalance = $this->getCurrentBalance($term->id);
        // value should pay in store
        $value = 0;
         
        if ($oldBalance > 0) {
            if ($this->is_old_installed) {
                $installment = $this->getReadyInstallment('old');
                $value = optional($installment)->value;
            } else 
                $value = $oldBalance;
        } else {
            if ($this->is_current_installed) {
                $value = optional(Installment::where('student_id', $this->id)->where('type', 'new')->where('paid', '0')->first())->value;
            } else
                $value = $currentBalance;
        }
        return $value;
    }

    /**
     * get paid value when student go to store
     * 
     * @return float
     */
    public function getPaidModel() {
        // current term
        $term = AccountSetting::getCurrentTerm();
        // old balance
        $oldBalance = $this->getOldBalance();
        // current balance of year
        $currentBalance = $this->getCurrentBalance($term->id);
        // value should pay in store
        $model = null;
         
        if ($oldBalance > 0) {
            if ($this->is_old_installed) {
                $model = Installment::where('student_id', $this->id)->where('type', 'old')->where('paid', '0')->first();
            } else 
                $model = null;
        } else {
            if ($this->is_current_installed) {
                $model = Installment::where('student_id', $this->id)->where('type', 'new')->where('paid', '0')->first();
            } else
                $model = $this->getCurrentExpenses()->first();
        }
        return $model;
    }
 
    
}
