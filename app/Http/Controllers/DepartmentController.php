<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $departments = Department::latest()->get();

            return response()->json([
                'data'      => $departments,
                'message'   => 'Success'
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'department_name'   => 'required|max:255',
                'address'           => 'required|max:255',
                'phone'             => 'required',
            ]);
            try{
                $department = Department::create([
                    'department_name'   => request('department_name'),
                    'address'           => request('address'),
                    'phone'             => request('phone'),
                ]);
                return response()->json([
                    'data'      => $department,
                    'message'   => 'Success'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        try{
            return response()->json([
                'data'      => $department,
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
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'department_name'   => 'required|max:255',
                'address'           => 'required|max:255',
                'phone'             => 'required',
            ]);

            try{
                $department->department_name = request('department_name');
                $department->address = request('address');
                $department->phone = request('phone');
                $department->save();

                return response()->json([
                    'data'      => $department,
                    'message'   => 'Department updated successfully!'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $department->delete();
                return response()->json([
                    'message' => 'Department deleted successfully!'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    public function getUserByDepartmentID(int $department_id)
    {
        try {
            $usersInDepartment = DB::table('departments')
                ->join('users', 'departments.id', '=', 'users.department_id')
                // ->select('name', 'email', 'department_name')
                ->where('departments.id', $department_id)->get()->toArray();

            return response()->json([
                'data'      => $usersInDepartment,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
