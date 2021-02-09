<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    // table of bank
    protected $table = "account_trees";
    
    protected $fillable = [
        'id',
        'parent',
        'icon',
        'type',
        'text' 
    ];
    
    protected $appends = ['can_delete'];
    
    public function getCanDeleteAttribute() {
        return !Daily::where('tree_id', $this->id)->exists();
    }
    
    
}
