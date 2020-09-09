<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Adminsion\Entities\RegisterationStatusDocument;
use Modules\Adminsion\Entities\RequiredDocument;

class RegisterationStatus extends Model
{
    protected $table = 'registeration_status';
    protected $fillable = ['name', 'notes'];
    
    
    /**
     * return all required document of registeration status
     * 
     * @return type
     */
    public function requiredDocuments() {
        $ids = RegisterationStatusDocument::where('registeration_status_id', $this->id)->pluck('required_document_id')->toArray();
        return RequiredDocument::whereIn('id', $ids); 
    }
}
