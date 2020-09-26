<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "account_services";
   
    protected $fillable = [
        'name', 
        'value', 
        'except_level_id', 
        'division_id', 
        'copy', 
        'repeat', 
        'store_id', 
        'additional_value', 
        'installment_percent',
        'from_installment_id', 
        'type' // 
    ];
      
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', 'store_id')->select(['id', 'name']);
    }
     
    public function level() {
        return $this->belongsTo('Modules\Divisions\Entities\Level', 'except_level_id')->select(['id', 'name']);
    }
    
    public function division() {
        return $this->belongsTo('Modules\Divisions\Entities\Division', 'division_id')->select(['id', 'name']);
    } 
    
}
