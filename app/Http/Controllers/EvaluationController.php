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

use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotification;
use App\Criteria;

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
        try {
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
        $dataArray = $request->all();

        // Get data from $request variable regardless of the key name of the array passed.
        foreach ($dataArray as $key => $value) {
            $inputData = $value;
        }

        // Result variable.
        $result = array();

        if ($role > 2) {
            try {
                //
                $inputCriteriaIDList = array();

                foreach ($inputData as $data) {
                    // Get maxScore of criteriaID.
                    $criteriaID = $data['criteria_id'];
                    $maxScore = DB::table('criteria')->where('id', $criteriaID)->first()->max_score;

                    // Validate.
                    Validator::make($data, [
                        'score'         => "required|numeric|max:$maxScore",
                        'criteria_id'   => 'required|numeric',
                    ]);

                    // Get and assign null to task_id if it not exist.
                    $taskID = $data['task_id'] ?? null;

                    // $time_start = microtime(true);

                    // Check if task_id already exists in evaluation if the passed task_id value is not null.
                    if ($taskID !== null) {

                        // Get task_id list.
                        $taskIDList = DB::table('evaluation')
                            ->select('task_id')
                            ->distinct()
                            ->where('task_id', '<>', null)
                            ->orderByDesc('task_id')
                            ->get();

                        $taskIDListArray = json_decode(json_encode($taskIDList), true);
                        $tempTaskIDArray = array();

                        foreach ($taskIDListArray as $id) {
                            array_push($tempTaskIDArray, $id['task_id']);
                        }

                        // Check if task_id already exists in evaluation.
                        if (in_array($taskID, $tempTaskIDArray)) {

                            // Get criteria_id list with this task_id in evaluation.
                            $criteriaIDList = DB::table('evaluation')
                                ->select('criteria_id')
                                ->where('task_id', $taskID)
                                ->orderByDesc('criteria_id')
                                ->get();

                            $criteriaIDListArray = json_decode(json_encode($criteriaIDList), true);
                            $tempCriteriaArray = array();

                            foreach ($criteriaIDListArray as $id) {
                                array_push($tempCriteriaArray, $id['criteria_id']);
                            }

                            // Check if the criteria_id already exists with this task_id.
                            if (in_array($criteriaID, $tempCriteriaArray)) {
                                // $time_end = microtime(true);
                                return response()->json([
                                    'message'   => "The criteria_id value already exists with this same task_id. Please try another value.",
                                    // 'time'      => $time_end - $time_start
                                ], 500);
                            }
                        }
                        else {
                            array_push($inputCriteriaIDList, $criteriaID);
                        }
                    }

                    // Get and assign null to user_id if it not exist.
                    $userID = $data['user_id'] ?? null;

                    // // Create.
                    // try {
                    //     $evaluation = Evaluation::create([
                    //         'task_id'       => $taskID,
                    //         'user_id'       => $userID,
                    //         'criteria_id'   => $criteriaID,
                    //         'score'         => $data['score'],
                    //         'note'          => $data['note'] ?? "",
                    //     ]);

                    //     if ($taskID !== null) {
                    //         // Update task status to EVALUATED and has been evaluated field to TRUE.
                    //         Task::where('id', $taskID)->update(['status_id' => 4]);
                    //         Task::where('id', $taskID)->update(['has_been_evaluated' => true]);

                    //         // Assign receiver_id in the notification table equal to assignee_id.
                    //         $receiverID = Task::findOrFail($evaluation->task_id)->assignee_id;
                    //     }

                    //     if ($userID !== null) {
                    //         // Update has been evaluated field to TRUE.
                    //         User::where('id', $userID)->update(['has_been_evaluated' => true]);

                    //         // Assign receiver_id in the notification table equal to user_id.
                    //         $receiverID = $userID;
                    //     }

                    //     // Get this evaluation and add to the result.
                    //     $maxEvaluationID = DB::table('evaluation')->max('id');
                    //     $temp = DB::table('evaluation')->where('id', $maxEvaluationID)->get()->toArray();
                    //     $result = array_merge($result, $temp);

                    //     // Create Notification.
                    //     $message = Auth::user()->name.' created a new evaluation.';

                    //     $notification = ([
                    //         'user_id'       => Auth::user()->id,
                    //         'type_id'       => 4,
                    //         'message'       => $message,
                    //         'content'       => json_encode($evaluation),
                    //         'receiver_id'   => $receiverID,
                    //         'has_seen'      => false,
                    //     ]);

                    //     // Dispatch to NotificationJob.
                    //     NotificationJob::dispatch($notification);

                    //     // Test mail notification.
                    //     // $receiverEmail = User::select('email')->where('id', $receiverID)->first()->email;

                    //     // $details = [
                    //     //     'subject'   => 'New Evaluation',
                    //     //     'title'     => 'New Evaluation',
                    //     //     'body'      => $message,
                    //     //     'url'       => route('admin.login'),
                    //     // ];

                    //     // Mail::to($receiverEmail)->send(new MailNotification($details));
                    // }
                    // catch(Exception $e){
                    //     return response()->json([
                    //         'message' => $e->getMessage()
                    //     ], 500);
                    // }
                }

                // Get criteria_id list with this task_id in criteria.
                $tempCriteriaIDListByTaskID = DB::table('criteria')
                    ->select('id as criteria_id')
                    ->where('task_id', $taskID)
                    ->get();

                $criteriaIDListArrayByTaskID = json_decode(json_encode($tempCriteriaIDListByTaskID), true);
                $criteriaIDListByTaskID = array();

                foreach ($criteriaIDListArrayByTaskID as $id) {
                    array_push($criteriaIDListByTaskID, $id['criteria_id']);
                }

                $a = array(1,2,3,4,76,78,9,10);
                $criteriaIDLeft = array_diff($a, $inputCriteriaIDList);

                //
                foreach ($criteriaIDLeft as $criIDLf) {
                    // Get maxScore of criteriaID.
                    $maxScore = DB::table('criteria')->where('id', $criIDLf)->first()->max_score;

                    $evaluation = Evaluation::create([
                        'task_id'       => $taskID,
                        'user_id'       => "",
                        'criteria_id'   => $criIDLf,
                        'score'         => $maxScore,
                        'note'          => "",
                    ]);

                    if ($taskID !== null) {
                        // Update task status to EVALUATED and has been evaluated field to TRUE.
                        Task::where('id', $taskID)->update(['status_id' => 4]);
                        Task::where('id', $taskID)->update(['has_been_evaluated' => true]);

                        // Assign receiver_id in the notification table equal to assignee_id.
                        $receiverID = Task::findOrFail($evaluation->task_id)->assignee_id;
                    }

                    // Get this evaluation and add to the result.
                    $maxEvaluationID = DB::table('evaluation')->max('id');
                    $temp = DB::table('evaluation')->where('id', $maxEvaluationID)->get()->toArray();
                    $result = array_merge($result, $temp);
                }

                return response()->json([
                    // 'data'      => $inputData,
                    'test'      => $criteriaIDListByTaskID,
                    'temp'      => $criteriaIDLeft,
                    // 'time'      => $time_end - $time_start,
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

                    // Assign receiver_id in the notification table equal to assignee_id.
                    $receiverID = Task::findOrFail($evaluation->task_id)->assignee_id;
                }

                if ($userID !== null) {
                    // Update has been evaluated field to TRUE.
                    User::where('id', $userID)->update(['has_been_evaluated' => true]);

                    // Assign receiver_id in the notification table equal to user_id.
                    $receiverID = $userID;
                }

                // Create Notification.
                $message = Auth::user()->name.' updated the evaluation.';

                $notification = ([
                    'user_id'       => Auth::user()->id,
                    'type_id'       => 4,
                    'message'       => $message,
                    'content'       => json_encode($evaluation),
                    'receiver_id'   => $receiverID,
                    'has_seen'      => false,
                ]);

                // Dispatch to NotificationJob.
                NotificationJob::dispatch($notification);

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
        if ($role > 2) {
            try {
                if ($evaluation->task_id !== null) {
                    // Assign receiver_id in the notification table equal to assignee_id.
                    $receiverID = Task::findOrFail($evaluation->task_id)->assignee_id;
                }

                if ($evaluation->user_id !== null) {
                    // Assign receiver_id in the notification table equal to user_id.
                    $receiverID = $evaluation->user_id;
                }

                // Create Notification.
                $message = Auth::user()->name.' deleted the evaluation.';

                $notification = ([
                    'user_id'       => Auth::user()->id,
                    'type_id'       => 4,
                    'message'       => $message,
                    'content'       => json_encode($evaluation),
                    'receiver_id'   => $receiverID,
                    'has_seen'      => false,
                ]);

                // Dispatch to NotificationJob.
                NotificationJob::dispatch($notification);

                // Delete.
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

    public function getUserEvaluationByUserID(int $user_id, int $month, int $year)
    {
        try {
            $userEvaluation = DB::table('evaluation')
            ->where('user_id', $user_id)
            ->whereMonth('created_at',$month)
            ->whereYear('created_at', $year)
            ->get();
            
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

    public function getTaskEvaluationListByUserId(int $user_id, int $month, int $year)
    {
        try {
            $userEvaluationList = DB::table('tasks')->join('evaluation','tasks.id', '=','evaluation.task_id')
            ->where('tasks.assignee_id',$user_id)
            ->whereMonth('evaluation.created_at',$month)
            ->whereYear('evaluation.created_at',$year)
            ->select('tasks.project_id','evaluation.score','tasks.id','tasks.task_name','tasks.assignee_id','tasks.start_date','tasks.end_date','evaluation.created_at','tasks.user_id','tasks.has_been_evaluated')
            ->get();
         
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
}
