<?php

namespace Modules\Reports\Entities;

use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    protected $table = "report_settings";
    
    protected $fillable = [ 
        'id', 'name', 'value'
    ];
}
