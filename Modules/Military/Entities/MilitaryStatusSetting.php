<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryStatusSetting extends Model
{
    protected $table = 'military_settings';
    protected $fillable = [
        'condition_age',
        'reason',
        'military_status_id',
        'notes'
    ];
    
    public function militaryStatus(){
        return $this->belongsTo('Modules\Military\Entities\MilitaryStatus', 'military_status_id');
    }
}
