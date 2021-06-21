<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\PermissionRequest;
use Exception;

class PermissionController extends Controller
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
        $permissions = Permission::with('group')->get();
        return view('admin.permission.list', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionGroups = GroupPermission::all();
        return view('admin.permission.add', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            $permission = new Permission();

            $permission->display_name = $request->display_name;

            $permission->name = changeTitle($request->display_name);

            $permission->description = $request->description;
            $permission->group_permission_id = $request->group_permission_id;

            $permission->save();

            return redirect('admin/permission')->with('success', 'Thêm mới thành công');
        }
        catch(Exception $e){
            return redirect('admin/permission')->with('error', 'Thêm mới thất bại');
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
            $permission = Permission::findOrFail($id);
            return response()->json([
                'data'      => $permission,
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
        $permission = Permission::findOrFail($id);
        $permissionGroups = GroupPermission::all();

        return view('admin.permission.edit', compact('permission', 'permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);

            $permission->display_name = $request->display_name;

            $permission->name = changeTitle($request->display_name);

            $permission->description = $request->description;
            $permission->group_permission_id = $request->group_permission_id;

            $permission->save();

            return redirect('admin/permission')->with('success', 'Cập nhật thành công');
        }
        catch(Exception $e){
            return redirect('admin/permission')->with('error', 'Cập nhật thất bại');
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
            $permission = Permission::findOrFail($id);

            if (!$permission) {
                return redirect('admin/permission')->with('error', 'Dữ liệu không tồn tại');
            }

            $permission->delete();

            return redirect('admin/permission')->with('success', 'Đã xóa thành công');
        }
        catch(Exception $e){
            return redirect('admin/permission')->with('error', 'Xóa thất bại');
        }
    }
}
