<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class BalanceReset extends Model
{
    protected $table = "account_balance_reset";

    protected $fillable = [
        'student_id',
        'user_id',
        'date',
        'value',
        'notes',
        'type'
    ]; 
 
    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id");
    } 

    public function user() {
        return $this->belongsTo("App\User", "user_id")->select(['id', 'name']);
    }


}
