<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\UserJobs;
use Modules\Settings\Http\Requests\UserJobsRequest;

class UserJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users_jobs = UserJobs::OrderBy('created_at', 'desc')->get();
        return view('settings::user_jobs.index', compact('users_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::user_jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $settings = UserJobs::create($request->all());
            if ($settings) {
                return redirect()->route('users-jobs.index')->with(['success' => 'تم حفظ الاعداداتٍ بنجاح']);
            }
            return redirect()->route('users-jobs.index')->with(['success' => 'تم حفظ الاعداداتٍ بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);
        }
        //
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
        $setting = UserJobs::select()->find($id);
        if (!$setting) {
            return redirect()->route('users-jobs.index')->with(['error' => 'هذه الاعدادات غير موجودة !']);
        }

        return view('settings::user_jobs.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $setting = UserJobs::find($id);
            if (!$setting) {
                return redirect()->route('users-jobs.index')->with(['error' => 'هذه الاعدادات غير موجودة !']);
            } else {

                $setting->update($request->all());
                return redirect()->route('users-jobs.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
            }

        } catch (\Exception $ex) {
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
        try {
            $setting = UserJobs::find($id);
            if (!$setting) {
                return redirect()->route('users-jobs.index')->with(['error' => 'هذه الاعدادات غير موجودة !']);
            }

            $users = $setting->user();
            if (isset($users) && $users->count() > 0) {
                return redirect()->route('users-jobs.index')->with(['error' => 'لا يمكن مسح هذه الوظيفة !']);
            } else {
                $setting->delete();
                return redirect()->route('users-jobs.index')->with(['success' => 'تم الحذف بنجاح']);
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاولة فى وقت لاحق']);
        }
    }
}
