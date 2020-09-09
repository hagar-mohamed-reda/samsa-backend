<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name' ,'level_id','notes'];
}
