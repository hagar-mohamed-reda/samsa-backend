<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Discount extends Model
{
    protected $table = "account_discounts";

    protected $fillable = [
        'student_id',
        'attachment',
        'value',
        'discount_request_id',
        'user_id',
    ];

    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id");
    }

    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }

}
