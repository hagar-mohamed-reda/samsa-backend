<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class RequiredDocument extends Model
{
    protected $table = 'required_documents';
    protected $fillable = ['name', 'notes', 'type'];
    
}
