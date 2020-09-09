<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Reword extends Model
{
    protected $table = "account_rewords";
    
    protected $fillable = [
        'name',
        'value', 
        'notes'
    ];
      
    public function canDelete() {
        return $this->payment? false : true;
    }
    
    public function payment() {
        return $this->hasOne('Modules\Account\Entities\Payment', 'reword_id');
    }
}
