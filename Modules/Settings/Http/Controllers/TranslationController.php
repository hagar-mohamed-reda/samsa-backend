<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Translation;

class TranslationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        return view('settings::translation.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) {
        try {
            $data = json_decode($request->data); 
            
            foreach($data as $item) { 
                $translation = Translation::find($item->id);
                $translation->update([
                    "name_ar" => $item->name_ar,
                    "name_en" => $item->name_en
                ]);
            }
             
            notfy(__('change translation'), __('change translation'), "fa fa-language"); 
            return responseJson(1, __('proccess has been success')); 
        } catch (Exception $th) {
            return responseJson(0, $th->getMessage()); 
        } 
    }

}
