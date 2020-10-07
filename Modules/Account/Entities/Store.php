<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Store extends Model
{
    protected $table = "account_stores"; 
    
    protected $fillable = [
        "id", "name", "address", "balance", "notes", "user_id", "init_balance"
    ];
    
    protected $appends = [
        'can_delete'
    ];

    public function getCanDeleteAttribute() {
        $count = DB::table('account_payments')->where('store_id', $this->id)->count(); 
        return $count > 0 ? false : true;
    }

    public function user() {
        return $this->belongsTo('App\User', "user_id");
    }
    
    public function transformations() {
        return $this->hasMany("Modules\Account\Entities\Transformation", "store_id");
    }
    
    public function deposites() {
        return $this->hasMany("Modules\Account\Entities\Deposite", "store_id");
    }
    
    public function canDelete() {
        return !($this->transformations()->count() > 0 || $this->deposites()->count() > 0)? true : false;
    }
 
    public function updateStore($value) {
        $this->balance += $value;
        $this->update();
    }
}
