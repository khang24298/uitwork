<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Task;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function index()
    {
        try{
            $criteria = Criteria::latest()->get();

            return response()->json([
                'criteria' => $criteria,
                'message' => 'Success'
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
        //
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'criteria_name'     => 'required|max:255',
                'criteria_type_id'  => 'required',
                'description'       => 'required',
                'score'             => 'required'
            ]);
            try{
                $criteria = Criteria::create([
                    'criteria_name'     => request('criteria_name'),
                    'criteria_type_id'  => request('criteria_type_id'),
                    'description'       => request('description'),
                    'score'             => request('score'),
                    'task_id'           => request('task_id'),
                    'user_id'           => Auth::user()->id
                ]);
                return response()->json([
                    'criteria'    => $criteria,
                    'message' => 'Success'
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
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function show(Criteria $criteria)
    {
        try{
            return response()->json([
                'criteria' => $criteria,
                'message' => 'Success'
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
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Criteria $criteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
        //
    }

    public function calculateScoreByUserTask(int $task_id)
    {
        try {
            $score = DB::table('criteria')->where('task_id', $task_id)->sum('score');

            return response()->json([
                'score'     => $score,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calculateScoreByUserCriteria(int $user_id)
    {
        try {
            $score = DB::table('criteria')->where('user_id', $user_id)->sum('score');

            return response()->json([
                'score'     => $score,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskCriteria()
    {
        try {
            $taskCriteria = DB::table('criteria')->where('criteria_type_id', 1)->get();

            return response()->json([
                'taskCriteria'      => $taskCriteria,
                'message'           => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserCriteria()
    {
        try {
            $userCriteria = DB::table('criteria')->where('criteria_type_id', 2)->get();

            return response()->json([
                'userCriteria'      => $userCriteria,
                'message'           => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
