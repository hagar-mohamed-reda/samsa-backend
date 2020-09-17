<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student as StudentOrigin;

use DB;

class Student extends StudentOrigin
{

    protected $table = "students";
    
    protected $appends = [
        'is_current_installed', 
        'is_old_installed', 
        'current_balance', 
        'old_balance', 
        'paid_value',
        'paids',
        'gpa',
        'services',
        'image'
    ];
    
    public function getOldBalanceAttribute() {
        return $this->getStudentBalance()->getOldBalance();
    }
    
    public function getCurrentBalanceAttribute() {
        return $this->getStudentBalance()->getCurrentBalance();
    }
    
    public function getPaidValueAttribute() {
        return $this->getStudentBalance()->getPaidValue();
    }

    public function getPaidsAttribute() {
        return $this->payments()->sum("value");
    }

    public function getGpaAttribute() {
        return 1.5;
    }
    
    public function getServicesAttribute() {
        $ids = StudentService::where('student_id', $this->id)->pluck('service_id')->toArray();
        return Service::whereIn('id', $ids)->get(); 
    }

    public function getImageAttribute() {
        $resource = DB::table('student_required_documents')->where('student_id', $this->id)->where('required_document_id', 4)->first();
        $path = optional($resource)->path;

        return $path? url($path) : null;
    }

    public function getStudentBalance() {
        return StudentBalance::find($this->id);
    }
     
    public function getIsCurrentInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'new')
                ->first();
        
        return $installment? true : false;
    }
     
    public function getIsOldInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'old')
                ->first();
        
        return $installment? true : false;
    }
    
    public function installments() {
        return $this->hasMany("Modules\Account\Entities\Installment", "student_id")->orderBy('date');
    }

    public function payments() {
        return $this->hasMany("Modules\Account\Entities\Payment", "student_id");
    }

    public function level() {
        return $this->belongsTo("Modules\Divisions\Entities\Level", "level_id")->select(['id', 'name']);
    }

    public function division() {
        return $this->belongsTo("Modules\Divisions\Entities\Division", "division_id")->select(['id', 'name']);
    }

    public function canGetService() {

    }

    public function getAvailableServices() {
        $ids = [];
        $services = Service::all();

        foreach ($services as $service) {
            if (AccountSetting::canStudentGetService($service, $this)) {
                $ids[] = $service->id;
            }
        }

        return Service::whereIn('id', $ids)->get(['id', 'name', 'value', 'additional_value']);
    }
 
 

}
