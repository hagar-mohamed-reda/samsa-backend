<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

use DB;

class Installment extends Model
{
    protected $table = "account_installments";
    
    protected $fillable = [
        'date_from',
        'date_to',
        'value',
        'student_id',
        'user_id',
        'installment_id',
        'type',   // [main, sub]
        'target',  // madunia	
        'paid'  // 0, 1
    ];
    
    protected $appends = [
        'remaining', 'paid'
    ];
    
    public function getPaidAttribute() { 
        
        return $this->payments()->sum('value') + Payment::whereIn('installment_id', $this->installments()->pluck('id')->toArray())->sum('value');
    }
    
    public function getRemainingAttribute() { 
        
        return $this->value - ($this->payments()->sum('value') + Payment::whereIn('installment_id', $this->installments()->pluck('id')->toArray())->sum('value'));
    }
    
    public function isPaid() {
        if ($this->payments()->sum('value') >= $this->value) {
            return true;
        }
        return false;
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
    
    public function payment() {
        return $this->hasOne('Modules\Account\Entities\Payment', "installment_id");
    }
    
    public function payments() {
        return $this->hasMany('Modules\Account\Entities\Payment', "installment_id");
    }
    
    public function installments() {
        return $this->hasMany('Modules\Account\Entities\Installment', "installment_id");
    }
}
