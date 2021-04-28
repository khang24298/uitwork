<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
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
            $position = Position::latest()->get();

            return response()->json([
                'data'      => $position,
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
                'position_name'         => 'required|max:255',
                'description'           => 'required|max:255',
                'salary_id'             => 'required',
            ]);

            try{
                $position = Position::create([
                    'position_name'         => request('position_name'),
                    'description'           => request('description'),
                    'salary_id'             => request('salary_id'),
                ]);
                return response()->json([
                    'data'      => $position,
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
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'position_name'         => 'required|max:255',
                'description'           => 'required|max:255',
                'salary_id'             => 'required',
            ]);

            try{
                $position->position_name = request('position_name');
                $position->description = request('description');
                $position->salary_id = request('salary_id');
                $position->save();

                return response()->json([
                    'data'      => $position,
                    'message'   => 'Position updated successfully!'
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
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $position->delete();
                return response()->json([
                    'message' => 'Position deleted successfully!'
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

    public function getSalaryInfoByPositionID(int $position_id)
    {
        try {
            $salaryInfo = DB::table('positions')->join('salaries', 'positions.salary_id', '=', 'salaries.id')
                ->select('salary_scale', 'basic_salary', 'allowance_coefficient')
                ->where('positions.id', $position_id)->get();

            return response()->json([
                'data'      => $salaryInfo,
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
