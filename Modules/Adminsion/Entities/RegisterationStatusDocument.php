<?php

namespace Modules\Adminsion\Entities;

use Illuminate\Database\Eloquent\Model;



class RegisterationStatusDocument extends Model
{
    protected $table = 'registeration_status_document';
    
    protected $fillable = [
        'registeration_status_id',	
        'required_document_id'  
    ];
    
    
    public function registerationStatus() {
        return $this->belongsTo('Modules\Settings\Entities\RegisterationStatus', 'registeration_status_id');
    }
    
    public function requiredDocument() {
        return $this->belongsTo("Modules\Adminsion\Entities\RequiredDocument", 'required_document_id');
    }
     
}
