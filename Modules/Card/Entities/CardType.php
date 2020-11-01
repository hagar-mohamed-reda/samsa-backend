<?php

namespace Modules\Card\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class CardType extends Model
{
    protected $table = "card_types";

    protected $fillable = [
        'name', 
        'service_id',
        'image'
    ];

    protected $appends = [
    	'image_url'
    ];

    public function getImageUrlAttribute() {
    	return url($this->image);
    }

    public function service() {
        return $this->belongsTo("Modules\Account\Entities\Service", "service_id");
    }
 

}
