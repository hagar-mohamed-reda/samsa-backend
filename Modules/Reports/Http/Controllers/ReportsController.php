<?php

namespace Modules\Reports\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Reports\Entities\ReportSetting; 

class ReportsController extends Controller
{
    
    /**
     * global setting of the report
     * 
     * @return Html
     */
    public function setting()
    {
        return view('reports::index');
    }
    
    
    /**
     * A letter sending the file transferred to the institute
     * 
     * @return Html
     */
    public function letterSendingToInstitute()
    {
        $html = optional(ReportSetting::find(1))->value; 
        return view('reports::letter_sending_to_institute', compact('html'));
    }
    
    
    /**
     * A letter sending the file transferred from the institute
     * 
     * @return Html
     */
    public function letterSendingFromInstitute()
    {
        $html = optional(ReportSetting::find(2))->value; 
        return view('reports::letter_sending_from_institute', compact('html'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update($setting, Request $request) {
        try { 
            $object = ReportSetting::find($setting);
            
            if (!$object) {
                $object = ReportSetting::create([
                    "id" => $setting,
                    "name" => $request->name,
                    "value" => $request->value,
                ]);
            }
            
            $object->update($request->all());
            
            notify()->success(__('process has been success'), "", "bottomLeft", "fa fa-language");
            notfy(__('change report setting'), __('change report setting'), "fa fa-cogs"); 
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "fa fa-cogs");
        }
        return redirect()->route('reportSetting');
    }
    
}
