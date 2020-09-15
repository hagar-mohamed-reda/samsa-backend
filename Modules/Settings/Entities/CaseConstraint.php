<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class CaseConstraint extends Model
{
    protected $table = 'case_constraints';
    protected $fillable = ['name', 'notes'];
    protected $hidden = ['created_at', 'updated_at'];
}
