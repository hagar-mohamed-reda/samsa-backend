<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Solfa extends Model {

    // table of bank
    protected $table = "account_solfa";
    protected $fillable = [
        'name', 'date', 'value', 'store_id', 'user_id',
        'kst1', 'kst2', 'kst3', 'kst4', 'kst5', 'kst6',
        'kst7', 'kst8', 'kst9', 'kst10', 'kst11', 'kst12'
    ];
    protected $appends = ['can_delete', 'remained'];

    public function getRemainedAttribute() {
        return $this->value - ($this->kst1 + $this->kst2 + $this->kst3 + $this->kst4 + $this->kst5 + $this->kst6 + $this->kst7 + $this->kst8 + $this->kst9 + $this->kst10 + $this->kst11 + $this->kst12);
    }
    
    public function getCanDeleteAttribute() {
        return true;
    }

}
