<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';
    protected $fillable = ['key', 'name_ar', 'name_en'];
}
