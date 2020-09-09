<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $table = "account_trees";
    
    protected $fillable = [ 
        'id',
        'parent',
        'icon',
        'type',
        'text'
    ];
      
}
