<?php

namespace Modules\Adminsion\Entities;

use Illuminate\Database\Eloquent\Model;

class ApplicationRequired extends Model
{
    protected $table = 'application_required';
    protected $fillable = ['name', 'required'];
}
