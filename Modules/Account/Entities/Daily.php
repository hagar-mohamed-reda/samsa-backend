<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model {

    // table of bank
    protected $table = "account_dailies";
    protected $fillable = [
        'date', 'value', 'tree_id', 'user_id', 'notes', 'store_id'
    ];
    protected $appends = ['can_delete'];

    public function getCanDeleteAttribute() {
        return true;
    }

}
