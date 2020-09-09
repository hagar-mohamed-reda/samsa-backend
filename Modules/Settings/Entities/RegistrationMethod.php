<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class RegistrationMethod extends Model
{
    protected $table = 'registration_methods';
    protected $fillable = ['name', 'notes'];
}
