<?php

namespace Modules\Card\Entities;
 
use Modules\Account\Entities\Student;
use Modules\Account\Entities\AccountSetting;

class CardReason  
{
     

    /**
     * check on the reason of the card 
     *
     * @return Array
     */
    public static function getReasons(Student $student,  CardType $card) {
        $res = AccountSetting::canStudentGetService($card->service, $student);
        $reasons = [];

        if ($student->case_constraint_id == 1) {
            $reasons[] = "الطالب غير مقيد بالمعهد";
        }

        if (!$res['valid']) 
            $reasons[] = $res['reason'];

        if (!$student->personal_photo)
            $reasons[] = "الطالب ليس له صورة";

        return $reasons;
    }


    /**
     * check if the student can take card
     *
     * @return Array
     */
    public static function canTakeCard(Student $student,  CardType $card) {
        return count(self::getReasons($student, $card)) > 0? false : true;
    }
}
