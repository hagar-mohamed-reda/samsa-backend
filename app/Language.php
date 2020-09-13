<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';
    protected $fillable = ['name', 'notes'];

    protected $hidden = ["created_at", "updated_at"];
    public function applicationsLang1() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'language_1_id');
    }
    public function applicationsLang2() {
        return $this->hasMany('Modules\Adminsion\Entities\Application', 'language_2_id');
    }

    public function studentsLang1() {
        return $this->hasMany('Modules\Student\Entities\Student', 'language_1_id');
    }
    public function studentsLang2() {
        return $this->hasMany('Modules\Student\Entities\Student', 'language_2_id');
    }

}
