<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $table = "account_fines";
    
    protected $fillable = [
        'name',
        'value', 
        'notes'
    ];
      
    public function planDetail() {
        return $this->hasOne('Modules\Account\Entities\PlanDetail', 'id'); //fine_id
    }
}
