<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class TeamWork extends Model
{
    protected $table = "team_work";
    
    protected $fillable = [
        'name',	'sign_image', 'notes', 'value'
    ];
}
