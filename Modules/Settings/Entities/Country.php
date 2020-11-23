<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name', 'notes'];
}
