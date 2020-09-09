<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:countries_read'])->only('index');
        $this->middleware(['permission:countries_create'])->only('create');
        $this->middleware(['permission:countries_update'])->only('edit');
        $this->middleware(['permission:countries_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::OrderBy('created_at', 'desc')->get();
        return view('main_settings.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        try {
            $country = Country::create($request->all());
            if($country){
                notify()->success("تم حفظ الاعدادات بنجاح","","bottomLeft",);
                return redirect()->route('countries.index');
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
                return redirect()->route('countries.index');
            }
        } catch (\Throwable $th) {
            notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('countries.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country) {
            notify()->error("هذه الاعدادات غير موجودة !","","bottomLeft",);
            return redirect()->route('countries.index');
        }
        return view('main_settings.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        try {
            $country = Country::find($id);
            if (!$country) {
                notify()->warning("هذه الاعدادات غير موجودة !","","bottomLeft",);
                return redirect()->route('countries.index')->with(['error' => 'هذه الاعدادات غير موجودة !']);
            } else {

                $country->update($request->all());
                notify()->success("تم تعديل الاعدادات بنجاح","","bottomLeft",);
                return redirect()->route('countries.index');
            }
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('countries.index');        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $country = Country::find($id);
            if (!$country) {
                notify()->warning("هذه الاعدادات غير موجودة !","","bottomLeft",);
                return redirect()->route('countries.index');
            }
            $governments = $country->governments->count();
            if(isset($governments) && $governments > 0 ){
                notify()->error("لا يمكن حذف هذا العنصر","","bottomLeft",);
                return redirect()->route('countries.index')->with(['error' => 'لا يمكن حذف هذا العنصر']);
            }else{
                $country->delete();
                notify()->success("تم الحذف بنجاح","","bottomLeft",);
                return redirect()->route('countries.index');
            }

        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('countries.index');
        }

    }
}
