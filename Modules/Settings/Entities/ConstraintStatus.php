<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class ConstraintStatus extends Model
{
    protected $table = 'constraint_status';
    protected $fillable = ['name' ,'notes'];
}
