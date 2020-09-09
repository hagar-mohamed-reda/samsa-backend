<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Deposite extends Model
{
    protected $table = "account_deposites";
    
    protected $fillable = [
        'value',
        'date',
        'attachment',
        'type',  // [store, bank]
        'user_id',
        'store_id',
        'bank_id',
        'notes',
        'confirm' // [0, 1]
    ];
    
    protected $appends = [
        'attachment_url'
    ];
    
    public function getAttachmentUrlAttribute() {
        return url('/') . "/" . $this->attachment;
    }


    public function user() {
        return $this->belongsTo('App\User', "user_id");
    }
    
    public function store() {
        return $this->belongsTo('Modules\Account\Entities\Store', "store_id");
    }
    
    public function bank() {
        return $this->belongsTo('Modules\Account\Entities\Bank', "bank_id");
    }
}
