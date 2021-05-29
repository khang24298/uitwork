<?php

namespace App\Http\Controllers;

use App\Evaluation;

use Exception;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Validator;
use App\Notification;
use App\Jobs\NotificationJob;
use App\User;
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

        // DataType of evaluations : Array.
        $dataArray = $request->evaluations;

        // Result variable.
        $result = array();

        if ($role > 2) {
            try {
                foreach ($dataArray as $data) {
                    // Get maxScore of criteriaID.
                    $criteriaID = $data['criteria_id'];
                    $maxScore = DB::table('criteria')->select('max_score')->where('id', $criteriaID)->get();

                    // Validate.
                    Validator::make($data, [
                        'score'         => "required|numeric|max:$maxScore",
                        'criteria_id'   => 'required|numeric',
                    ]);

                    // Get and assign null to task_id if it not exist.
                    $taskID = $data['task_id'] ?? null;

                    // Check if task_id already exists in evaluation if the passed task_id value is not null.
                    if ($taskID !== null) {
                        // Check if task_id already exists in evaluation.
                        $taskIDList = DB::table('evaluation')->select('task_id')->where('task_id', '<>', null)->get();
                        $taskIDListArray = json_decode(json_encode($taskIDList), true);
                        $tempTaskIDArray = array();

                        for ($i = 0; $i < count($taskIDListArray) - 1; $i++) {
                            array_push($tempTaskIDArray, $taskIDListArray[$i]['task_id']);
                        }

                        if (in_array($taskID, $tempTaskIDArray)) {
                            // Check if the criteria_id already exists with this task_id.
                            $criteriaIDList = DB::table('evaluation')
                                ->select('criteria_id')
                                ->where('task_id', $taskID)->get();

                            $criteriaIDListArray = json_decode(json_encode($criteriaIDList), true);
                            $tempCriteriaArray = array();

                            for ($i = 0; $i < count($criteriaIDListArray) - 1; $i++) {
                                array_push($tempCriteriaArray, $criteriaIDListArray[$i]['criteria_id']);
                            }

                            if (in_array($criteriaID, $tempCriteriaArray)) {
                                return response()->json([
                                    'message' => "The criteria_id value already exists with this same task_id. Please try another value."
                                ], 500);
                            }
                        }
                    }

                    // Get and assign null to user_id if it not exist.
                    $userID = $data['user_id'] ?? null;

                    // Create.
                    try {
                        $evaluation = Evaluation::create([
                            'task_id'       => $taskID,
                            'user_id'       => $userID,
                            'criteria_id'   => $criteriaID,
                            'score'         => $data['score'],
                            'note'          => $data['note'] ?? "",
                        ]);

                        if ($taskID !== null) {
                            // Update task status to EVALUATED and has been evaluated field to TRUE.
                            Task::where('id', $taskID)->update(['status_id' => 4]);
                            Task::where('id', $taskID)->update(['has_been_evaluated' => true]);
                        }

                        if ($userID !== null) {
                            // Update has been evaluated field to TRUE.
                            User::where('id', $userID)->update(['has_been_evaluated' => true]);
                        }

                        // Get this evaluation and add to the result.
                        $maxEvaluationID = DB::table('evaluation')->max('id');
                        $temp = DB::table('evaluation')->where('id', $maxEvaluationID)->get()->toArray();
                        $result = array_merge($result, $temp);

                        // Create Notification.
                        $message = Auth::user()->name.' created a new evaluation.';

                        $notification = ([
                            'user_id'   => Auth::user()->id,
                            'type_id'   => 4,
                            'message'   => $message,
                            'content'   => json_encode($evaluation),
                            'has_seen'  => false,
                        ]);

                        // Dispatch to NotificationJob.
                        NotificationJob::dispatch($notification)->delay(now()->addSeconds(30));
                    }
                    catch(Exception $e){
                        return response()->json([
                            'message' => $e->getMessage()
                        ], 500);
                    }
                }
                return response()->json([
                    'data'      => $result,
                    'message'   => 'Success'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
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

        if ($role > 2) {
            // Get maxScore of criteriaID.
            $criteriaID = request('criteria_id');
            $maxScore = DB::table('criteria')->select('max_score')->where('id', $criteriaID)->get();

            // Validate.
            $this->validate($request, [
                'score'         => "required|numeric|max:$maxScore",
                'criteria_id'   => 'required|numeric',
            ]);

            // Get and assign null to task_id if it not exist.
            $taskID = request('task_id') ?? null;

            // Check if task_id already exists in evaluation if the passed task_id value is not null.
            if ($taskID !== null) {
                // Check if task_id already exists in evaluation.
                $taskIDList = DB::table('evaluation')->select('task_id')->where('task_id', '<>', null)->get();
                $taskIDListArray = json_decode(json_encode($taskIDList), true);
                $tempTaskIDArray = array();

                for ($i = 0; $i < count($taskIDListArray) - 1; $i++) {
                    array_push($tempTaskIDArray, $taskIDListArray[$i]['task_id']);
                }

                if (in_array($taskID, $tempTaskIDArray)) {
                    // Check if the criteria_id already exists with this task_id.
                    $criteriaIDList = DB::table('evaluation')
                        ->select('criteria_id')
                        ->where('task_id', $taskID)->get();

                    $criteriaIDListArray = json_decode(json_encode($criteriaIDList), true);
                    $tempCriteriaArray = array();

                    for ($i = 0; $i < count($criteriaIDListArray) - 1; $i++) {
                        array_push($tempCriteriaArray, $criteriaIDListArray[$i]['criteria_id']);
                    }

                    if (in_array($criteriaID, $tempCriteriaArray)) {
                        return response()->json([
                            'message' => "The criteria_id value already exists with this same task_id. Please try another value."
                        ], 500);
                    }
                }
            }

            // Get and assign null to user_id if it not exist.
            $userID = request('user_id') ?? null;

            try {
                $evaluation->user_id = $userID;
                $evaluation->task_id = $taskID;
                $evaluation->criteria_id = $criteriaID;
                $evaluation->score = request('score');
                $evaluation->note = request('note') ?? "";
                $evaluation->save();

                if ($taskID !== null) {
                    // Update task status to EVALUATED and has been evaluated field to TRUE.
                    Task::where('id', $taskID)->update(['status_id' => 4]);
                    Task::where('id', $taskID)->update(['has_been_evaluated' => true]);
                }

                if ($userID !== null) {
                    // Update has been evaluated field to TRUE.
                    User::where('id', $userID)->update(['has_been_evaluated' => true]);
                }

                // Create Notification.
                $message = Auth::user()->name.' updated the evaluation.';

                $notification = ([
                    'user_id'   => Auth::user()->id,
                    'type_id'   => 4,
                    'message'   => $message,
                    'content'   => json_encode($evaluation),
                    'has_seen'  => false,
                ]);

                // Dispatch to NotificationJob.
                NotificationJob::dispatch($notification)->delay(now()->addSeconds(30));

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
        } else {
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
            try {
                $evaluation->delete();

                // Create Notification.
                $message = Auth::user()->name.' deleted the evaluation.';

                $notification = ([
                    'user_id'   => Auth::user()->id,
                    'type_id'   => 4,
                    'message'   => $message,
                    'content'   => json_encode($evaluation),
                    'has_seen'  => false,
                ]);

                // Dispatch to NotificationJob.
                NotificationJob::dispatch($notification)->delay(now()->addSeconds(30));

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
