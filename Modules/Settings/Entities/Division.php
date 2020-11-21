<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
    protected $fillable = ['name', 'notes'];
}
