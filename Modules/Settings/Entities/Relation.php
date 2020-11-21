<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = 'parent_relation_type';
    protected $fillable = ['name', 'notes'];
}
