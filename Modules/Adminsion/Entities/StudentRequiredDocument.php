<?php

namespace Modules\Adminsion\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentRequiredDocument extends Model
{
    protected $table = 'student_required_documents';

    protected $fillable = ['required_document_id', 'student_id', 'path', 'notes'];

    protected $appends = [
    	'path_url'
    ];

    public function getPathUrlAttribute() {
    	return url('/') . "" . $this->path;
    }

    public function requiredDocument() {
        return $this->belongsTo("Modules\Adminsion\Entities\RequiredDocument", 'required_document_id');
    }
}
