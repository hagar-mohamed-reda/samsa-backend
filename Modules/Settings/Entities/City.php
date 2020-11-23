<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name', 'government_id', 'notes'];
}
