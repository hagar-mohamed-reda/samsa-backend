<?php

namespace Modules\Adminsion\Entities;

use Illuminate\Database\Eloquent\Model;

class RequiredDocument extends Model
{
    
    protected $table = 'required_documents';
    protected $fillable = [
        'name',	
        'type',	 // 	enum('original', 'copy', 'both')
        'notes'
    ];
    
    
    public function studentRequiredDocuments() {
        return $this->hasMany("Modules\Adminsion\Entities\StudentRequiredDocument", 'required_document_id');
    } 
}
