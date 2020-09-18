<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Translation;
use DB;

class TranslationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() { 
        return Translation::get()->pluck('value', 'key');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) {
        try {
            $data = $request->data;//json_decode(); 
            
            foreach($data as $item) { 
                $item = json_decode(json_encode($item));
                $translation = Translation::find($item->id);
                if ($translation) {
                    $translation->update([
                        "name_ar" => $item->name_ar,
                        "name_en" => $item->name_en
                    ]);
                } else {
                    $translation = Translation::create([
                        "key" => $item->key,
                        "name_ar" => $item->key,
                        "name_ar" => $item->key,
                    ]);
                }
            }
             
            notfy(__('change translation'), __('change translation'), "fa fa-language"); 
            return responseJson(1, __('proccess has been success')); 
        } catch (Exception $th) {
            return responseJson(0, $th->getMessage()); 
        } 
    }

}
