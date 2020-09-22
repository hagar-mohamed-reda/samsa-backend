<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{

    //public $guarded = [];
    protected $fillable= ['name'];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
