<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:languages_read'])->only('index');
        $this->middleware(['permission:languages_create'])->only('create');
        $this->middleware(['permission:languages_update'])->only('edit');
        $this->middleware(['permission:languages_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::OrderBy('created_at', 'desc')->get();
        return view('main_settings.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        try {
            $language = Language::create($request->all());
            if ($language) {
                notify()->success("تم حفظ الاعدادات بنجاح","","bottomLeft",);
                return redirect()->route('languages.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
                return redirect()->route('languages.index');
            }
        } catch (\Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('languages.index');
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
        $language = Language::find($id);
        if (!$language) {
            notify()->warning("هذه الاعدادات غير موجودة","","bottomLeft",);
            return redirect()->route('languages.index');
        }
        return view('main_settings.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
    {
        try {
            $language = Language::find($id);

            if (!$language) {
                notify()->warning("هذه الاعدادات غير موجودة ","","bottomLeft",);
                return redirect()->route('languages.index');
            } else {
                $language->update($request->all());
                notify()->success("تم تعديل البيانات بنجاح","","bottomLeft",);

                return redirect()->route('languages.index');
            }
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('languages.index');
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
            $language = Language::find($id);
            if (!$language) {
                notify()->warning("هذه البيانات غير موجودة","","bottomLeft",);

                return redirect()->route('languages.index');
            }
            $language->delete();
            notify()->success("تم الحذف بنجاح","","bottomLeft",);
            return redirect()->route('languages.index');

        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق","","bottomLeft",);
            return redirect()->route('languages.index');
        }
    }
}
