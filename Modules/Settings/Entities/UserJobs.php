<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class UserJobs extends Model
{
    protected $table = 'user_jobs';
    protected $fillable = ['name', 'active', 'notes'];

    public function getActive(){
        return $this->active == '1' ? " مفعل" : "غير مفعل" ;
     }

     public function user()
     {
         return $this->hasMany('App\User','job_id');
     }
}
