<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\RolePermission;
use App\User;
use App\UserPermission;

class RoleController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['permission:roles_read'])->only('index');
//        $this->middleware(['permission:roles_create'])->only('create');
//        $this->middleware(['permission:roles_update'])->only('edit');
//        $this->middleware(['permission:roles_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|unique,roles,name",
            "display_name" => 'required|unique,roles,display_name'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $role = Role::create($request->all());
            if ($role) {
                foreach ($request->permissions as $permission){
                    $permission_data = Permission::where('name', $permission)->first();
                    if( $permission_data == null){
                        $permissionss = [
                            'name'=> $permission
                        ];
                       $permission_data =  Permission::create($permissionss);
                    }
                    $permission_role = [
                        'role_id' => $role->id,
                        'permission_id'=> $permission_data->id
                    ];
                    RolePermission::create($permission_role);
                    return responseJson(1, __('data created successfully'), $city);
                }

            } else {
                notify()->error("هناك خطأ ما يرجى المحاولةzcvvv فى وقت لاحق", "", "bottomLeft" );
                return redirect()->route('roles.index');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
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
        $role = Role::find($id);
       
        if (!$role) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if(!$role){
            notify()->error('هذه الاعدادات غير موجودة', "", "bottomLeft", );
            return redirect()->route('roles.index');
        }
       return view('main_settings.roles.edit', compact('role'));

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
        $validator = validator($request->all(), [
            "name" => "required",
            "display_name" => 'required|exists:governments,id'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {

            $role = Role::find($id);
            if(!$role){
                notify()->error('هذه الاعدادات غير موجودة', "", "bottomLeft", );
                return redirect()->route('roles.index');
            }else{
                $role->name = $request->name;

                if($request->has('permissions') && $request->permissions != []){
                    //get role permissions and delete it
                    $role_permissions = RolePermission::where('role_id', $role->id)->get();
                    $role->detachPermissions($role_permissions);

                    foreach ($request->permissions as $permission){
                        $permission_data = Permission::where('name', $permission)->first();
                        if( $permission_data == null){
                            $permissionss = [
                                'name'=> $permission
                            ];
                           $permission_data =  Permission::create($permissionss);
                        }
                        $permission_role = [
                            'role_id' => $role->id,
                            'permission_id'=> $permission_data->id
                        ];
                        RolePermission::create($permission_role);
                    }

                }else{
                    $role->detachPermissions([]);
                }
                $role->update();
                return responseJson(1, __('data updated successfully'), $role);
                
            }

        } catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(), "");
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
        $role = Role::find($id);
        $users = User::all();

        foreach($users as $user){
            if($user -> hasRole($role->name)){
                return responseJson(1,' لا يمكن حذف هذه الصلاحية', '');

            }else{
                $role->forceDelete();
                return responseJson(1, __('deleted successfully'), '');
            }
        }
    }
}
