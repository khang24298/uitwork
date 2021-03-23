<?php

namespace App\Http\Controllers;

use App\Salary;
use App\User;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
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
            $salaries = Salary::latest()->get();

            return response()->json([
                'salaries'    => $salaries,
                'message'     => 'Success'
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
                'salary_scale'           => 'required',
                'basic_salary'           => 'required',
                'allowance_coefficient'  => 'required',
            ]);
            try{
                $salary = Salary::create([
                    'salary_scale'           => request('salary_scale'),
                    'basic_salary'           => request('basic_salary'),
                    'allowance_coefficient'  => request('allowance_coefficient'),
                ]);
                return response()->json([
                    'salary'    => $salary,
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
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'salary_scale'   => 'required',
                'basic_salary'   => 'required',
                'allowance_coefficient'   => 'required',
            ]);

            try{
                $salary->salary_scale = request('salary_scale');
                $salary->basic_salary = request('basic_salary');
                $salary->allowance_coefficient = request('allowance_coefficient');
                $salary->save();

                return response()->json([
                    'salary'  => $salary,
                    'message' => 'Salary updated successfully!'
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
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $salary->delete();
                return response()->json([
                    'message' => 'Salary deleted successfully!'
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

    public function calculateUserSalaryByUserID(int $user_id)
    {
        try {
            $userPosition = DB::table('users')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->select('users.id', 'users.name', 'position_id', 'salary_id', 'education_level_id')
                ->toSql();

            $userSalaryInfo = DB::table('salaries')
                ->joinSub($userPosition, 'user_position', function($join) {
                    $join->on('salaries.id', '=', 'user_position.salary_id');
                })
                ->select('user_position.name', 'basic_salary', 'salary_scale',
                    'allowance_coefficient', 'education_level_id')
                ->where('user_position.id', $user_id)->get();

            $userSalary = ($userSalaryInfo[0]->salary_scale + $userSalaryInfo[0]->allowance_coefficient)
                    * $userSalaryInfo[0]->basic_salary;

            return response()->json([
                'userSalary'    => $userSalary,
                'message'       => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
