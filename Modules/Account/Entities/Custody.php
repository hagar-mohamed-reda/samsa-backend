<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
    // table of bank
    protected $table = "account_custodies";
    
    protected $fillable = [
        'date',
	'name',
	'value',
	'store_id'
    ];
    
    protected $appends = ['can_delete'];
    
    public function getCanDeleteAttribute() {
        return true;
    }
      
}
