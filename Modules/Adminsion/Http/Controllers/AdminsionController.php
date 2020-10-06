<?php

namespace Modules\Adminsion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class AdminsionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function updateSetting(Request $request)
    {
        $model = DB::table('globale_settings')->find($request->id);

        if (!$model) {
            $model = DB::table('globale_settings')->insert([
                ["id" => $request->id, "name" => "Adminsion setting", "value" => $request->value]
            ]);
        } else {
            $model->update([
                "value" => $request->value
            ]);
        }

        return responseJson(1, __('done'), $model);
    }

    public function getSettings() {
        return DB::table('globale_settings')->get();
    }
 
}
