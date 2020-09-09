<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    protected $table = "account_dailies";
    
    protected $fillable = [
        'date',
        'value',
        'store_id',
        'tree_id',
        'user_id', 
        'type', 
        'notes'
    ];
     
    public function store() {
        return $this->belongsTo("Modules\Account\Entities\Store", "store_id");
    }
     
    public function tree() {
        return $this->belongsTo("Modules\Account\Entities\Tree", "tree_id");
    }
     
    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }
}
