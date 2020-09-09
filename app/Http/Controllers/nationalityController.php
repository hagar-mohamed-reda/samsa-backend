<?php

namespace App\Http\Controllers;

use App\Http\Requests\NationalityRequest;
use App\Nationality;
use Illuminate\Http\Request;

class nationalityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:nationalities_read'])->only('index');
        $this->middleware(['permission:nationalities_create'])->only('create');
        $this->middleware(['permission:nationalities_update'])->only('edit');
        $this->middleware(['permission:nationalities_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nationalities = Nationality::OrderBy('created_at', 'desc')->get();
        return view('main_settings.nationalities.index', compact('nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.nationalities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NationalityRequest $request)
    {
        try {
            $nationality = Nationality::create($request->all());
            if($nationality){
                notify()->success("تم حفظ البيانات بنجاح","","bottomLeft",);

                return redirect()->route('nationalities.index');
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
                return redirect()->route('nationalities.index');
            }
        } catch (\Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('nationalities.index');
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
        $nationality = Nationality::find($id);
        if (!$nationality) {
            notify()->warning("هذه البيانات غير موجودة !","","bottomLeft",);
            return redirect()->route('nationalities.index');
        }
        return view('main_settings.nationalities.edit', compact('nationality'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NationalityRequest $request, $id)
    {
        try {
            $nationality = Nationality::find($id);
            if (!$nationality) {
                notify()->warning("هذه البيانات غير موجودة !","","bottomLeft",);

                return redirect()->route('nationalities.index');
            } else {

                $nationality->update($request->all());
                notify()->success("تم تعديل البيانات بنجاح","","bottomLeft",);
                return redirect()->route('nationalities.index');
            }
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('nationalities.index');
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
        try {
            $nationality = Nationality::find($id);

            if (!$nationality) {
                notify()->warning("هذه البيانات غير موجودة !","","bottomLeft",);

                return redirect()->route('nationalities.index');
            }
            $nationality->delete();
            notify()->success("تم الحذف بنجاح","","bottomLeft",);

            return redirect()->route('nationalities.index');
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('nationalities.index');
        }
    }
}
