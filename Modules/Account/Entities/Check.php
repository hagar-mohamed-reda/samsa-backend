<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Check extends Model {

    // table of bank
    protected $table = "account_checks";
    protected $fillable = [
        'date', 'number', 'person', 'notes', 'value', 'is_paid', 'bank_id', 'attachment'
    ];
    protected $appends = ['can_delete', 'attachment_url'];

    public function getAttachmentUrlAttribute() {
        return url('/uploads/check') . "/" .  $this->attachment;
    }
    
    public function getCanDeleteAttribute() {
        return true;
    }
    
    public function bank() {
        return $this->belongsTo(Bank::class, "bank_id");
    }

}
