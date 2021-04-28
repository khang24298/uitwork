<?php

namespace App\Http\Controllers;

use App\Evaluation;

use Exception;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
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
            $evaluation = Evaluation::get();

            return response()->json([
                'data'      => $evaluation,
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
            $criteriaID = request('criteria_id');
            $maxScore = DB::table('criteria')->select('max_score')->where('id', $criteriaID)->get();

            $this->validate($request, [
                'score'         => 'required',
                'criteria_id'   => 'required',
                'user_id'       => 'nullable',
                'task_id'       => 'nullable',
                'note'          => 'nullable'
            ]);

            try{
                $criteria = Evaluation::create([
                    'task_id'       => request('task_id'),
                    'user_id'       => Auth::user()->id,
                    'criteria_id'   => request('criteria_id'),
                    'score'         => request('score'),
                    'note'          => request('note'),
                ]);
                Task::where('id',request('task_id'))->update(['status_id' => 4]);
                return response()->json([
                    'data'      => $criteria,
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
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        try{
            return response()->json([
                'data'      => $evaluation,
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
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'score'             => 'required',
                'criteria_id'       => 'required',
                'user_id'           => 'nullable',
                'task_id'           => 'nullable',
                'note'              => 'nullable',
            ]);

            try{
                $evaluation->user_id = Auth::user()->id;
                $evaluation->task_id = request('task_id');
                $evaluation->criteria_id = request('criteria_id');
                $evaluation->note = request('note');
                $evaluation->score = request('score');
                $evaluation->save();

                return response()->json([
                    'data'      => $evaluation,
                    'message'   => 'Evaluation updated successfully!'
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
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $evaluation->delete();
                return response()->json([
                    'message' => 'Evaluation deleted successfully!'
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

    public function getTaskEvaluationByTaskID(int $task_id)
    {
        try {
            $taskEvaluation = DB::table('evaluation')->where('task_id', $task_id)->orderBy('criteria_id','ASC')->get()->toArray();

            return response()->json([
                'data'      => $taskEvaluation,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskEvaluationList()
    {
        try {
            $taskEvaluationList = DB::table('evaluation')->where('task_id', '<>', null)->get();

            return response()->json([
                'data'      => $taskEvaluationList,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserEvaluationByUserID(int $user_id)
    {
        try {
            $userEvaluation = DB::table('evaluation')->where('user_id', $user_id)->get();

            return response()->json([
                'data'      => $userEvaluation,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserEvaluationList()
    {
        try {
            $userEvaluationList = DB::table('evaluation')->where('user_id', '<>', null)->get();

            return response()->json([
                'data'      => $userEvaluationList,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calcTaskCriteriaScoreByTaskID(int $task_id)
    {
        try {
            $score = DB::table('evaluation')->where('task_id', $task_id)->sum('score');

            return response()->json([
                'data'      => $score,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calcUserCriteriaScoreByUserID(int $user_id)
    {
        try {
            $score = DB::table('evaluation')->where('user_id', $user_id)->sum('score');

            return response()->json([
                'data'      => $score,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calcTotalTaskCriteriaScoreByUserID(int $user_id)
    {
        try {
            $userTask = DB::table('users')
                ->join('tasks', 'users.id', '=', 'tasks.user_id')
                ->select('users.id AS userID', 'users.name', 'tasks.id')
                ->toSql();

            $score = DB::table('evaluation')
            ->joinSub($userTask, 'user_task', function($join) {
                $join->on('evaluation.task_id', '=', 'user_task.id');
            })
            ->select('user_task.name', 'evaluation.score', 'evaluation.task_id')
            ->where('user_task.userID', $user_id)->sum('score');

            return response()->json([
                'data'      => $score,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calcTotalUserScore(int $user_id)
    {
        try {
            $score_1 = DB::table('evaluation')->where('user_id', $user_id)->sum('score');

            $userTask = DB::table('users')
                ->join('tasks', 'users.id', '=', 'tasks.user_id')
                ->select('users.id AS userID', 'users.name', 'tasks.id')
                ->toSql();

            $score_2 = DB::table('evaluation')
            ->joinSub($userTask, 'user_task', function($join) {
                $join->on('evaluation.task_id', '=', 'user_task.id');
            })
            ->select('user_task.name', 'evaluation.score', 'evaluation.task_id')
            ->where('user_task.userID', $user_id)->sum('score');

            $score = $score_1 + $score_2;

            return response()->json([
                'data'      => $score,
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
