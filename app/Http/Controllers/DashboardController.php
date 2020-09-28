<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Entities\AccountSetting;

class DashboardController extends Controller
{
    /** 
     */
    public function getSettings()
    {
        $settings = [];
        $settings['current_academic_year'] = AccountSetting::getCurrentAcademicYear();
        $settings['current_term'] = AccountSetting::getCurrentTerm();

        return $settings;
    }
 
}
