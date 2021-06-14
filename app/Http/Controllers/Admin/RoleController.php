<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $roles = Role::all();
        return view('admin.role.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.add', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = new Role();

            $role->display_name = $request->display_name;
            $role->name = changeTitle($request->display_name);
            $role->description = $request->description;

            $role->save();

            // Attach Permission.
            foreach ($request->permission as $key => $value){
                $role->attachPermission($value);
            }

            return redirect('admin/role')->with('success', 'Thêm mới thành công');
        }
        catch(Exception $e){
            return redirect('admin/role')->with('error', 'Thêm mới thất bại');
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
        try {
            $role = Role::findOrFail($id);
            return response()->json([
                'data'      => $role,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_role = $role->permissions()->pluck('id', 'id')->toArray();

        return view('admin.role.edit', compact('role', 'permissions', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        try {
            // Find and Update.
            $role = Role::findOrFail($id);

            $role->display_name = $request->display_name;
            $role->name = changeTitle($request->display_name);
            $role->description = $request->description;

            $role->save();

            // Delete old relationship.
            DB::table('permission_role')->where('role_id', $id)->delete();

            // Attach Permission.
            foreach ($request->permission as $key => $value){
                $role->attachPermission($value);
            }

            return redirect('admin/role')->with('success', 'Cập nhật thành công');
        }
        catch(Exception $e){
            return redirect('admin/role')->with('error', 'Cập nhật thất bại');
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
            $role = Role::findOrFail($id);

            if (!$role) {
                return redirect('admin/role')->with('error', 'Dữ liệu không tồn tại');
            }

            $role->delete();

            return redirect('admin/role')->with('success', 'Đã xóa thành công');
        }
        catch(Exception $e){
            return redirect('admin/role')->with('error', 'Xóa thất bại');
        }
    }
}
