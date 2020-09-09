<?php

namespace Modules\Account\Entities;
 
use Modules\Settings\Entities\AcademicYear;

class AccountSetting  
{
    
    /**
     * return current academic year of system
     * 
     * @return AcademicYear
     */
    public static function getCurrentAcademicYear() {
        // get current year
        $currentYear = date("Y");
        
        // next year
        $nextYear = $currentYear + 1;
        
        // academic year name
        $name = $currentYear."-".$nextYear;
        
        return AcademicYear::where('name', $name)->first();
    }
    
    /**
     * get current term
     * 
     * @return Term
     */
    public static function getCurrentTerm() {
        // get current date
        $date = date('m-d');
        
        return Term::where('id', 1)->first();
    }
}
