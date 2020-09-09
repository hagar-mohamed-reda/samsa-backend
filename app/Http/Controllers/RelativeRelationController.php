<?php

namespace App\Http\Controllers;

use App\RelativeRelation;
use Illuminate\Http\Request;

class RelativeRelationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:relations_read'])->only('index');
        $this->middleware(['permission:relations_create'])->only('create');
        $this->middleware(['permission:relations_update'])->only('edit');
        $this->middleware(['permission:relations_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $relativeRelations = RelativeRelation::OrderBy('created_at', 'DESC')->get();
        return view('main_settings.relative_relations.index', compact('relativeRelations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.relative_relations.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $relativeRelations = RelativeRelation::create($request->all());
            if ($relativeRelations) {
                notify()->success("تم حفظ الاعدادات بنجاح", "", "bottomLeft", );
                return redirect()->route('relations.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
                return redirect()->route('relations.index');
            }
        } catch (\Exception $th) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('relations.index');
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
        $relativeRelation = RelativeRelation::find($id);
        if (!$relativeRelation) {
            notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
            return redirect()->route('relations.index');
        }
        return view('main_settings.relative_relations.edit', compact('relativeRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $relativeRelation = RelativeRelation::find($id);
            if (!$relativeRelation) {
                notify()->warning("هذه الاعدادات غير موجودة ", "", "bottomLeft", );
                return redirect()->route('relations.index');
            } else {
                $relativeRelation->update($request->all());
                notify()->success("تم تعديل الاعدادات بنجاح", "", "bottomLeft", );
                return redirect()->route('relations.index');
            }
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('relations.index');
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
            $relativeRelation = RelativeRelation::find($id);
            if (!$relativeRelation) {
                notify()->warning("هذه الاعدادات غير موجودة", "", "bottomLeft", );
                return redirect()->route('relations.index');
            }
            $relativeRelation->delete();
            notify()->success("تم الحذف بنجاح", "", "bottomLeft", );
            return redirect()->route('relations.index');
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft", );
            return redirect()->route('relations.index');
        }
    }
}
