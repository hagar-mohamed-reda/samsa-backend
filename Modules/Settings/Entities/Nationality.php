<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $table = 'nationalities';
    protected $fillable = ['name', 'notes'];
}
