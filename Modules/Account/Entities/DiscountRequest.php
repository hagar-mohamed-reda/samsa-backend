<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class DiscountRequest extends Model
{
    protected $table = "account_discount_requests";

    protected $fillable = [
        'student_id',
        'discount_type_id',
        'reason',
        'student_affairs_notes',
        'user_id',
        'paid'
    ];

    protected $appends = [
        'value'
    ];

    public function getValueAttribute() {
        return optional(Discount::where('discount_request_id', $this->id)->first())->value;
    }

    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id");
    }

    public function discountType() {
        return $this->belongsTo("Modules\Account\Entities\DiscountType", "discount_type_id");
    }

    public function user() {
        return $this->belongsTo("App\User", "user_id")->select(['id', 'name']);
    }


}
