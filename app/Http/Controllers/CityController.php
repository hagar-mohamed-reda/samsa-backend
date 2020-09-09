<?php

namespace App\Http\Controllers;

use App\City; 
use App\Http\Requests\CityRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:cities_read'])->only('index');
        $this->middleware(['permission:cities_create'])->only('create');
        $this->middleware(['permission:cities_update'])->only('edit');
        $this->middleware(['permission:cities_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { 
        $cities = City::OrderBy('created_at', 'desc')->get();
        return view('main_settings.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('main_settings.cities.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CityRequest $request)
    {
        try {
            $city = City::create($request->all());
            if ($city) {
                notfy(__('add city'), __('add city') .' '. $city->name, 'fa fa-building-o');
                notify()->success(__('process has been success'), "", "bottomLeft" );
                return redirect()->route('cities.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
                return redirect()->route('cities.index');
            }
            
        } catch (Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('cities.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $city = City::find($id);
        if (!$city) {
            notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
            return redirect()->route('cities.index');
        }
        return view('main_settings.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CityRequest $request, $id)
    {
        try {
            $city = City::find($id);
            if (!$city) {
                notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
                return redirect()->route('cities.index');
            } else {
                $city->update($request->all());
                notify()->success("تم تعديل الاعدادات بنجاح", "", "bottomLeft", );
                return redirect()->route('cities.index');
            }
        } catch (Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('cities.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $city = City::find($id);
            if (!$city) {
                notify()->warning("هذه الاعدادات غير موجودة", "", "bottomLeft", );
                return redirect()->route('cities.index');
            }
            $city->delete();
            notify()->success("تم الحذف بنجاح", "", "bottomLeft", );
            return redirect()->route('cities.index');
        } catch (Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('cities.index');
        }
    }
}
