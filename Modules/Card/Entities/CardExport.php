<?php

namespace Modules\Card\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class CardExport extends Model
{
    protected $table = "card_exports";

    protected $fillable = [
        'student_id', 
        'card_id',
        'date',
        'rf_code',
        'payment_id'
    ];

    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id")->with(['level', 'division']);
    }
  
    public function card() {
        return $this->belongsTo("Modules\Card\Entities\CardType", "card_id")->with(['service']);
    }

}
