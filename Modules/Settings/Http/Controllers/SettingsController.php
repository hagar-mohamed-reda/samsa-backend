<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Setting;
use Modules\Settings\Http\Requests\SettingRequest;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:settings_read'])->only('index');
        $this->middleware(['permission:settings_create'])->only('create');
        $this->middleware(['permission:settings_update'])->only('edit');
        $this->middleware(['permission:settings_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $settings = Setting::all();
        return view('settings::index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $serrtin = Setting::first();
        $serrtin->update($request->all());
        dd($serrtin);
        try {
            $settings = Setting::create($request->all());
            if($settings){
                return redirect()->route('settings.index')->with(['success' => 'تم حفظ الاعداداتٍ بنجاح']);
            }
            return redirect()->route('settings.index')->with(['success' => 'تم حفظ الاعداداتٍ بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $setting = Setting::select()->find($id);
        if(!$setting){

            return redirect() -> route('settings.index') -> with(['error' => 'هذه الاعدادات غير موجودة !']);
        }

        return view('settings::edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(SettingRequest $request, $id)
    {
        try{
            $setting = Setting::find($id);

            if(!$setting){

                return redirect() -> route('settings.index') -> with(['error' => 'هذه الاعدادات غير موجودة !']);
            }else{

                $setting->update($request->all());
                return redirect() -> route('settings.index') -> with(['success' => 'تم تحديث البيانات بنجاح']);
            }

        }
        catch(\Exception $ex){
            return redirect()->back()->with(['error' => $ex]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try{
            $setting = Setting::find($id);
            if(!$setting){

                return redirect() -> route('settings.index') -> with(['error' => 'هذه الاعدادات غير موجودة !']);
            }else{

                $setting->delete();
                return redirect() -> route('settings.index') -> with(['success' => 'تم الحذف بنجاح']);
            }

        }
        catch(\Exception $ex){
            return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاولة فى وقت لاحق']);
        }
    }
}
