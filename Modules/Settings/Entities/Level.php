<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';
    protected $fillable = ['name', 'notes'];
}
