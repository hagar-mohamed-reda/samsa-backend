<?php

namespace Modules\Card\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class CardType extends Model
{
    protected $table = "card_types";

    protected $fillable = [
        'name', 
        'service_id'
    ];

    public function service() {
        return $this->belongsTo("Modules\Account\Entities\Service", "service_id");
    }
 

}
