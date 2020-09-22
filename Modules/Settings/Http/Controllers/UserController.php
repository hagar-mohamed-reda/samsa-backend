<?php

namespace Modules\Settings\Http\Controllers;

use App\Role;
use App\RolePermission;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Settings\Http\Requests\UserRequest;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:users_read'])->only('index');
//        $this->middleware(['permission:users_create'])->only('create');
//        $this->middleware(['permission:users_update'])->only('edit');
//        $this->middleware(['permission:users_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = User::with(['role'])->OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $users);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email'=>'required|email|unique:users,email',
            'phone' => 'required|max:11|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {

            $input = $request->except('image', 'permissions', 'password');
            if ($request->has('image')) {
                $image = saveImage($request->image, 'users');
                $input['image'] = $image;
            } else {
                $input['image'] = 'uploads/users/User_icon_2.svg.png';
            }
            $input['password'] = Hash::make($request->password);
            $input['api_token'] = Str::random(32);
        //    if($request->has('role_id'))
        //    dd($request->role_id);

            $user = User::create($input);
            if($user){
                if($request->has('role_id')){
                    $role = Role::find($request->role_id);
                        $permissions_role = RolePermission::where('role_id', $role->id)->get();
                        $user->attachRole($role->name);
                        $user->role;
                }
            }
            
           
            return responseJson(1, __('data created successfully'), $user);
            // if($user ){
            //     $role = Role::find($request->role_id);
            //     $permissions_role = RolePermission::where('role_id', $role->id)->get();
            //     $user->attachRole($role->name);
            //     // foreach($permissions_role as $permission_role){
            //     //     $permission_user = [
            //     //         'permission_id' => $permission_role->permission_id,
            //     //         'user_id'=> $user->id,
            //     //         'user_type'=>'App\User'
            //     //     ];

            //     //     UserPermission::create($permission_user);
            //     // }
            //     // $user->attachPermissions($request->permissions); // parameter can be a Permission object, array or id

            //     return responseJson(1, __('data created successfully'), $user);

            // } else {
            //     return responseJson(1, __('data created successfully'), $user);

            //     notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft" );
            //     return redirect()->route('governments.index');
            // }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(),"" );
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->role;
        if (!$user) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $user);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(User $user)
    {
        $roles = $user->getRoles();
        return view('settings::users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'phone' => 'required|max:11|unique:users,phone,'.$id,
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {

            $user = User::find($id);

            if (!$user) {
                return responseJson(0, "هذا المسنخدم غير موجود", );
            } else {

                //delete all user roles
                $input = $request->except('image');

                if ($request->hasFile('image')) {
                    deleteFile($user->image);
                    $input['image'] = saveImage($request->image, 'users');
                } else {
                    $input['image'] = $user->image;
                }
                if ($request->password != $user->password)
                $input['password'] = Hash::make($request->password);

                $roles = $user->getRoles();
                // dd($roles );

                if(!empty($roles)){
                    $user->detachRoles($roles);
                }

                // attach new roles
                $role = Role::find($request->role_id);
                $user->attachRole($role->name);
                $user = $user->update($input);

                return responseJson(1, __('data updated successfully'), $user);
            }

        } catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(), "");
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
            $user = User::find($id);
            if (is_null($user)) {
                return redirect()->back();
            }
    
            if ($user->image != null) {
                deleteFile($user->image);
            }
    
            $user->delete();
            return responseJson(1, __('deleted successfully'), '');
        }catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(), "");
        }
        
    }
}
