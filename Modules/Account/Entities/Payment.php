<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "account_payments";
    
    protected $fillable = [
        'student_id',
        'store_id',
        'date',
        'value',
        'user_id',
        'model_type', //[academic_year_expense, service, installment]
        'model_id', 
        'installment_id', 
        'service_count',
        'is_refund',
        'refund_id'
    ];

    protected $appends = [
        'model_object'
    ];

    public function getModelObjectAttribute() {
        $object = null;
        if ($this->model_type == "academic_year_expense") {
            $object = AcademicYearExpenseDetail::find($this->model_id);
        } 
        else if ($this->model_type == "installment") {
            $object = Installment::find($this->model_id);
        }
        if ($this->model_type == 'service') {
            return Service::find($this->model_id);
        }

        return $object;
    }
     
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', 'store_id');
    }
    
    public function student() {
        return $this->belongsTo('Modules\Account\Entities\Student', 'student_id');
    }
    
    public function model() {
        if ($this->model_type == 'academic_year_expense') {
            return $this->belongsTo('Modules\Account\Entities\AcademicYearExpenseDetail', 'model_id');
        }
        if ($this->model_type == 'service') {
            return $this->belongsTo('Modules\Account\Entities\Service', 'model_id');
        }
        
        return null;
    }

    public static function addPayment($data) {
        $payment = Payment::create($data);
        $store = $payment->store()->first();

        if ($store) {
            $store->updateStore($data['value']);
        }

        return $payment;
    }

    public static function addRefund($data) {
        $data['is_refund'] = 1;
        $payment = Payment::create($data);
        $store = $payment->store()->first();

        if ($store) {
            $store->updateStore($data['value'] * -1);
        }

        return $payment;
    }
}
