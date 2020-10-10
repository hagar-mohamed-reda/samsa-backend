<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

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
        'type', //
        'is_refund' 
    ];

    protected $appends = [
        'can_delete'
    ];

    public function getCanDeleteAttribute() {
        $count = DB::table('account_student_services')->where('service_id', $this->id)->count(); 
        return $count > 0 ? false : true;
    } 
    
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
