<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Transformation extends Model
{
    protected $table = "account_transformations";
    
    protected $fillable = [
        'date',
        'bank_id',
        'store_id',
        'value',
        'notes',
        'attachment',
        'user_id',
        'type'
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
