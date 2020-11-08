<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\AcademicSetting;
use Modules\Academic\Entities\AcademicSettingPrerequsite;


class SettingController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        return AcademicSetting::latest()->get();
    }
     

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $resource = null;


        try {
            foreach($request->settings as $item) {
                $setting = AcademicSetting::find($item['id']);

                if ($setting) {
                    $setting->update($item);
                }
                else {
                    $setting = AcademicSetting::create($item);
                }
            }
 

            watch(__('change academic settings '), "fa fa-cogs");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
    }
 
 
 
 
}
