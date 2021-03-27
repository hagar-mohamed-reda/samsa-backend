<?php

namespace App\Imports;

use Modules\Student\Entities\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		$file = $row[0] . ".txt";
		file_put_contents($file, $row[1]);
		return;
        return self::insertStudent($row);
    }
    
    public static function insertStudent(array $row) {
        $code = str_replace(" ", "", $row[0]);
        
        // check if the student exists
        if (!is_numeric($code) || !is_numeric($row[1])) {
            return null;
        }
        
        // check if the student exists
        if (Student::where('code', $code)->exists()) {
            return Student::where('code', $code)->first();
        }
        
        // create student if the student if not exist
        $resource = new Student([
            "code" => $code,
            "set_number" => $row[1],
            "name" => $row[2],
            "code" => $code,
            "username" => $code,
            "password" => $code,
            "national_id" => $code,
            "academic_years_id" => 1,
            "level_id" => 1,
            "department_id" => 1,
            "division_id" => 1
        ]);
        
        return $resource->refresh();
    }
}
