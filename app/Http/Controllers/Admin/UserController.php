<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('userRole', 'department')->get();
        return view('admin.user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('admin.user.add', compact('roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        // dd($request->all());
        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->department_id = $request->department_id;

            $user->password = Hash::make($request->password);
            $user->role = $request->role_id;
            $user->remember_token = $request->_token;

            // Default Fields.
            $user->email_verified_at = now();
            $user->position_id = 1;
            $user->education_level_id = 1;
            $user->has_been_evaluated = false;

            $user->save();

            // Attach Role.
            $user->attachRole($request->role_id);

            return redirect('admin/user')->with('success', 'Thêm mới thành công');
        }
        catch(Exception $e){
            return redirect('admin/user')->with('error', 'Thêm mới thất bại');
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
        $user = User::findOrFail($id);
        return response()->json([
            'data'      => $user,
            'message'   => 'Success'
        ],200);
    }

    /**
     * Get current user.
     * @return \Illuminate\Http\Response
     */
    public function currentUser(){
        $user = Auth::user();
        return response()->json([
            'data' => $user,
            'message' => "Success"
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $user_roles = DB::table('role_user')->get();
        $departments = Department::all();

        // $roles = Role::all();
        // $user_roles = $user->userRole()->pluck('id', 'id')->toArray();
        //
        // foreach ($user->roles as $key => $role) {
        //     $user_roles[] = $role->id;
        // }

        return view('admin.user.edit', compact('user','roles','user_roles','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            // Find and Update.
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->department_id = $request->department_id;

            $user->role = $request->role_id;
            $user->remember_token = $request->_token;

            $user->save();

            // Delete old relationship.
            DB::table('role_user')->where('user_id', $id)->delete();

            // Attach Role.
            $user->attachRole($request->role_id);

            return redirect('admin/user')->with('success', 'Cập nhật thành công');
        }
        catch(Exception $e){
            return redirect('admin/user')->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return redirect('admin/user')->with('error', 'Dữ liệu không tồn tại');
            }

            $user->delete();

            return redirect('admin/user')->with('success', 'Đã xóa thành công');
        }
        catch(Exception $e){
            return redirect('admin/user')->with('error', 'Xóa thất bại');
        }
    }
}
