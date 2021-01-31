<?php

namespace App\Imports;

use Modules\Academic\Entities\Course;
use Maatwebsite\Excel\Concerns\ToModel;

class CourseImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return self::insertCourse($row);
    }
    
    public static function insertCourse(array $row) {
        $code = str_replace(" ", "", $row[0]);
        $code = html_entity_decode($code);
        
        // check if the student exists
        if (Course::where('code', $code)->exists() || !isset($row[0]) || !isset($row[1])) {
            return Course::where('code', $code)->first();
        }
        
        $resource = new Course([
            "code" => $code,
            "name" => $row[1],
            "division_id" => 1,
            "level_id" => 1,
            "large_degree" => 100,
            "subject_category_id" => 1,
            "credit_hour" => 3
        ]);
        
        return $resource->refresh();
    }
}
