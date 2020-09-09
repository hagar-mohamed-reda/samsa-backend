<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "account_payments"; 
    
    protected $fillable = [ 
        'student_id', 
        'installment_id',
        'value',
        'user_id',
        'date',
        'attachment',
        'notes', 
        'discount',
        'payment_type', // [store, check]
        'store_id',
        'check_number',
        'account_number',
        'bank_name',
        'branch',
        'expense_main_id',
        //
        'reword_id',
    ];
    
    protected $appends = [
        'attachment_url'
    ];
    
    public function getAttachmentUrlAttribute() {
        return url('/') . "/" . $this->attachment;
    }
    
    public function user() {
        return $this->belongsTo('App\User', "user_id");
    }
    
    public function student() {
        return $this->belongsTo('Modules\Student\Entities\Student', "student_id");
    }
    
    public function installment() {
        return $this->belongsTo('Modules\Account\Entities\Installment', "installment_id");
    }
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', "store_id");
    }
    
    public function reword() {
        return $this->belongsTo('Modules\Account\Entities\Reword', "reword_id");
    }
    
    public function expenseMainCategory() {
        return $this->belongsTo('Modules\Account\Entities\ExpenseMainCategory', "expense_main_id");
    }
    
}
