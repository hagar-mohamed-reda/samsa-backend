<?php

namespace Modules\Adminsion\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;

use DB;

class Application extends Student {
  

    protected $appends = [
        'personal_photo_url', 'can_convert_to_student'
    ];

    public function getCanConvertToStudentAttribute() {
        $ids = DB::table("account_academic_year_expenses_details")->where('priorty', 1)->pluck('id')->toArray();
        $paymentCounts = DB::table('account_payments')
        ->where('model_type', 'academic_year_expense')
        ->where('student_id', $this->id)
        ->whereIn('model_id', $ids)->count();
    
        return $paymentCounts > 0? true : false;
    }

    public function getPersonalPhotoUrlAttribute() {
          
        $path = $this->personal_photo;

        return $path? url('/'). '' . $path : '/assets/img/avatar.png';
    }
 

}
