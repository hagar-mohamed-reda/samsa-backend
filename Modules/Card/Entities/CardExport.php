<?php

namespace Modules\Card\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class CardExport extends Model
{
    protected $table = "card_types";

    protected $fillable = [
        'student_id', 
        'card_id',
        'date'
    ];

    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id");
    }
  
    public function card() {
        return $this->belongsTo("Modules\Card\Entities\CardType", "card_id");
    }

}
