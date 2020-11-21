<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['name', 'notes'];
}
