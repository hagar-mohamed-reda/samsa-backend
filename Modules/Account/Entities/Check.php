<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Check extends Model {

    // table of bank
    protected $table = "account_checks";
    protected $fillable = [
        'date', 'number', 'person', 'notes', 'value', 'is_paid'
    ];
    protected $appends = ['can_delete'];

    public function getCanDeleteAttribute() {
        return true;
    }

}
