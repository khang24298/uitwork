<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\GroupPermissionRequest;
use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use Exception;
use Illuminate\Support\Facades\DB;

class GroupPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'admin']);

        view()->share([
            'group_permissions' => 'active'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permissionGroups = GroupPermission::all();

        // $viewData = [
        //     'data'  => $permissionGroups
        // ];

        // return view('admin.permission_group.list', $viewData);
        return view('admin.permission_group.list', ['permissionGroups' => $permissionGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.permission_group.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupPermissionRequest $request)
    {
        //
        DB::beginTransaction();

        try {
            $this->createOrUpdate($request);
            DB::commit();
            return redirect()->back()->with('success', 'Thêm mới thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Thêm mới thất bại');
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
        //
        $permissionGroup = GroupPermission::findOrFail($id);

        if (!$permissionGroup) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.permission_group.edit', compact('permissionGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupPermissionRequest $request, $id)
    {
        //
        DB::beginTransaction();

        try {
            $this->createOrUpdate($request, $id);
            DB::commit();
            return redirect()->back()->with('success', 'Chỉnh sửa thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Chỉnh sửa thất bại');
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
        //
        $permissionGroup = GroupPermission::findOrFail($id);

        if (!$permissionGroup) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $permissionGroup->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ta lỗi. Không thể xóa dữ liệu');
        }
    }

    //
    public function createOrUpdate($request, $id = '')
    {
        $groupPermission = new GroupPermission();

        if ($id) {
            $groupPermission = GroupPermission::findOrFail($id);
        }

        $groupPermission->name = $request->name;
        $groupPermission->description = $request->description;

        $groupPermission->save();
    }
}
