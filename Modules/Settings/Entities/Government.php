<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table = 'governments';
    protected $fillable = ['name','country_id', 'notes'];
}
