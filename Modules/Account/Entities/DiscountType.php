<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class DiscountType extends Model
{
    protected $table = "account_discount_types";

    protected $fillable = [
        'name'
    ];

    protected $appends = [
        'can_delete'
    ];

    /**
     * check if the discount type has relation in discount requests
     *
     */
    public function getCanDeleteAttribute() {
        return (DB::table('account_discount_requests')->where('discount_type_id', $this->id)->exists())? false : true;
    }

}
