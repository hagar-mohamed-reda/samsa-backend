<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model; 

class Transformation extends Model {

    // table of bank
    protected $table = "account_transformations";
    protected $fillable = [
        'date', 'value', 'user_id', 'notes', 'store_id', 'bank_id', 'type', 'attachment'
    ];
    protected $appends = ['can_delete', 'attachment_url'];

    public function getAttachmentUrlAttribute() {
        return url('/uploads/check') . "/" .  $this->attachment;
    }
    
    public function getCanDeleteAttribute() {
        return true;
    }

    public function user() {
        return $this->belongsTo(\App\User::class, "user_id");
    }
     
    public function bank() {
        return $this->belongsTo(Bank::class, "bank_id");
    }
    
    public function store() {
        return $this->belongsTo(Store::class, "store_id");
    }

}
