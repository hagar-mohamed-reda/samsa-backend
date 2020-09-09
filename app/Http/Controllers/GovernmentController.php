<?php

namespace App\Http\Controllers;

use App\Government;
use App\Http\Requests\GovernmentRequest;
use Illuminate\Http\Request;

class GovernmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:governments_read'])->only('index');
        $this->middleware(['permission:governments_create'])->only('create');
        $this->middleware(['permission:governments_update'])->only('edit');
        $this->middleware(['permission:governments_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governments = Government::OrderBy('created_at', 'desc')->get();
        return view('main_settings.governments.index', compact('governments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.governments.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GovernmentRequest $request)
    {
        try {
            $government = Government::create($request->all());
            if ($government) {
                notify()->success("تم حفظ الاعدادات بنجاح", "", "bottomLeft", );
                return redirect()->route('governments.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
                return redirect()->route('governments.index');
            }
        } catch (\Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('governments.index');
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
        $government = Government::find($id);
        if (!$government) {

            notify()->warning("هذه الاعدادات غير موجودة !", "", "bottomLeft", );
            return redirect()->route('governments.index');
        }
        return view('main_settings.governments.edit', compact('government'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GovernmentRequest $request, $id)
    {
        try {
            $government = Government::find($id);

            if (!$government) {
                notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
                return redirect()->route('governments.index');
            } else {

                $government->update($request->all());
                notify()->success("تم تعديل الاعدادات بنجاح", "", "bottomLeft", );

                return redirect()->route('governments.index');
            }
        } catch (\Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('governments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $government = Government::find($id);
        $cities = $government->cities->count();
        try {
            if (!$government) {
                notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
                return redirect()->route('governments.index');
            }
            if (isset($cities) && $cities > 0) {
                notify()->error("لا يمكن حذف هذا العنصر", "", "bottomLeft", );
                return redirect()->route('governments.index');
            } else {
                $government->delete();
                notify()->success("تم الحذف بنجاح", "", "bottomLeft", );
                return redirect()->route('governments.index');
            }

        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('governments.index');
        }
    }

    public function getGovernments($country_id){
         return  Government::where('country_id', $country_id)->pluck('id','name')->toArray();

    }
}
