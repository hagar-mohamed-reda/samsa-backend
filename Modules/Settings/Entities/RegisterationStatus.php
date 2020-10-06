<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Adminsion\Entities\RegisterationStatusDocument;
use Modules\Adminsion\Entities\RequiredDocument;
use DB;

class RegisterationStatus extends Model
{
    protected $table = 'registeration_status';
    protected $fillable = ['name', 'notes'];

    protected $appends = [
        'required_document_names', 'required_documents', 'can_delete'
    ];

    public function getRequiredDocumentNamesAttribute() {
        return $this->requiredDocuments()->pluck('name')->toArray();
    }
    
    public function getRequiredDocumentsAttribute() {
        return $this->requiredDocuments()->get();
    }
    
    public function getCanDeleteAttribute() {
        $can = true;
        if (DB::table('students')->where('registration_status_id', $this->id)->count() > 0)
            $can = false;

        return $can;
    }
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
