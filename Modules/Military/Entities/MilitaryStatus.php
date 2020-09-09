<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryStatus extends Model
{
    protected $table = 'military_status';
    protected $fillable = ['name', 'notes'];
}
