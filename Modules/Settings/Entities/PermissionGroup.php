<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $table = 'permission_groups';
    protected $fillable = ['name', 'sort'];
    
    protected $appends = ['can_delete'];
    
    public function permissions() {
        return $this->hasMany("Modules\Settings\Entities\Permission", "group_id")->orderBy('name');
    }
    
    public function getCanDeleteAttribute() {
        return !$this->permissions()->exists();
    }
}
