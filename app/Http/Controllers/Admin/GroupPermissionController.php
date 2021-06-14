<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\GroupPermissionRequest;
use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use Exception;
use Facade\FlareClient\Enums\GroupingTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $permissionGroups = GroupPermission::all();
        return view('admin.permission_group.list', compact('permissionGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        try {
            // $this->validate($request,
            //     [
            //         'name'          => 'required|min:5|max:100|unique:App\Models\GroupPermission,name',
            //         'description'   => 'required|min:5',
            //     ],
            //     [
            //         'name.required'         => 'Bạn chưa nhập tên nhóm quyền',
            //         'name.min'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            //         'name.max'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            //         'name.unique'           => 'Nhóm quyền này đã tồn tại',
            //         'description.required'  => 'Bạn chưa nhập mô tả cho nhóm quyền',
            //         'description.min'       => 'Mô tả cho nhóm quyền phải có tối thiểu 5 ký tự',
            //     ]
            // );

            // dd($request);

            GroupPermission::create([
                'name'          => $request->name,
                'description'   => $request->description,
            ]);

            return redirect('admin/permission-group')->with('success', 'Thêm mới thành công');
        }
        catch(Exception $e){
            return redirect('admin/permission-group')->with('error', 'Thêm mới thất bại');
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
            $permissionGroup = GroupPermission::findOrFail($id);
            return response()->json([
                'data'      => $permissionGroup,
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
        $permissionGroup = GroupPermission::findOrFail($id);

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
        try {
            $permissionGroup = GroupPermission::findOrFail($id);

            // $this->validate($request, [
            //         'name'          => [
            //             'required|min:5|max:100',
            //             Rule::unique('group_permissions', 'name')->ignore($groupPermission->id),
            //         ],
            //         'description'   => 'required|min:5',
            //     ],
            //     [
            //         'name.required'         => 'Bạn chưa nhập tên nhóm quyền',
            //         'name.min'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            //         'name.max'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            //         'name.unique'           => 'Nhóm quyền này đã tồn tại',
            //         'description.required'  => 'Bạn chưa nhập mô tả cho nhóm quyền',
            //         'description.min'       => 'Mô tả cho nhóm quyền phải có tối thiểu 5 ký tự',
            //     ]
            // );

            // dd($request);

            $permissionGroup->name = $request->name;
            $permissionGroup->description = $request->description;

            // dd($request);

            $permissionGroup->save();

            // dd($permissionGroup);

            return redirect('admin/permission-group')->with('success', 'Cập nhật thành công');
        }
        catch(Exception $e){
            return redirect('admin/permission-group')->with('error', 'Cập nhật thất bại');
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
            $permissionGroup = GroupPermission::findOrFail($id);

            if (!$permissionGroup) {
                return redirect('admin/permission-group')->with('error', 'Dữ liệu không tồn tại');
            }

            $permissionGroup->delete();

            return redirect('admin/permission-group')->with('success', 'Đã xóa thành công');
        }
        catch (Exception $e) {
            return redirect('admin/permission-group')->with('error', 'Xóa thất bại');
        }
    }
}
