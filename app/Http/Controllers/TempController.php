<?php

namespace App\Http\Controllers;

use App\Temp;
use Illuminate\Http\Request;
use Exception;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TempController extends Controller
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
            $temp = Temp::get();
            return response()->json([
                'data'      => $temp,
                'message'   => 'Success'
            ], 200);
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
        $this->validate($request, [
            'name'          => 'required|max:255',
            'description'   => 'required'
        ]);
        try{
            $temp = Temp::create([
                'name'          => request('name'),
                'description'   => request('description')
            ]);

            return response()->json([
                'data'      => $temp,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Temp  $temp
     * @return \Illuminate\Http\Response
     */
    public function show(Temp $temp)
    {
        try{
            return response()->json([
                'data'      => $temp,
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
     * @param  \App\Temp  $temp
     * @return \Illuminate\Http\Response
     */
    public function edit(Temp $temp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Temp  $temp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Temp $temp)
    {
        $this->validate($request, [
            'name'          => 'required|max:255',
            'description'   => 'required'
        ]);

        try {
            $temp->name = request('name');
            $temp->description = request('description');

            $temp->save();

            return response()->json([
                'data'      => $temp,
                'message'   => 'Temp updated successfully!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                    'message' => $e->getMessage()
                ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Temp  $temp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temp $temp)
    {
        try{
            $temp->delete();
            return response()->json([
                'message' => 'Temp deleted successfully!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function backupFunction()
    {
        // update in EvaluationController.
        // $role = Auth::user()->role;

        // if ($role > 2) {
            // // Get maxScore of criteriaID.
            // $criteriaID = request('criteria_id');
            // $maxScore = DB::table('criteria')->select('max_score')->where('id', $criteriaID)->get();

            // // Check if task_id already exists in evaluation.
            // $task_id = request('task_id');
            // $taskIDList = DB::table('evaluation')->select('task_id')->where('task_id', '<>', null)->get();
            // $taskIDListArray = json_decode(json_encode($taskIDList), true);
            // $temp = array();

            // for ($i = 0; $i < count($taskIDListArray) - 1; $i++) {
            //     array_push($temp, $taskIDListArray[$i]['task_id']);
            // }

            // if (!in_array($task_id, $temp)){
            //     return response()->json([
            //         'message' => "Success"
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'message' => "The criteria_id value already exists with this same task_id. Please try another value."
            //     ], 200);
            // }

            // $this->validate($request, [
            //     'score'             => "required|max:$maxScore",
            //     'criteria_id'       => 'required',
            // ]);

            // try{
            //     $evaluation->user_id = Auth::user()->id;
            //     $evaluation->task_id = request('task_id');
            //     $evaluation->criteria_id = request('criteria_id');
            //     $evaluation->note = request('note');
            //     $evaluation->score = request('score');
            //     $evaluation->save();

            //     // Create Notification.
            //     $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
            //     $message = $userName[0]->name.' updated the evaluation.';

            //     Notification::create([
            //         'user_id'   => Auth::user()->id,
            //         'type_id'   => 4,
            //         'message'   => $message,
            //         'content'   => json_encode($evaluation),
            //         'has_seen'  => false,
            //     ]);

            //     return response()->json([
            //         'data'      => $evaluation,
            //         'message'   => 'Evaluation updated successfully!'
            //     ], 200);
            // }
            // catch(Exception $e){
            //     return response()->json([
            //         'message' => $e->getMessage()
            //     ], 500);
            // }
        // } else{
        //     return response()->json([
        //         'message' => "You don't have access to this resource! Please contact with administrator for more information!"
        //     ], 403);
        // }




        // update in EvaluationController if $request is a array.
        // $role = Auth::user()->role;

        // // DataType of evaluations : Array.
        // $dataArray = $request->evaluations;

        // if ($role > 2) {
        //     try {
        //         foreach ($dataArray as $data) {
        //             // Get maxScore of criteriaID.
        //             $criteriaID = $data['criteria_id'];
        //             $maxScore = DB::table('criteria')->select('max_score')->where('id', $criteriaID)->get();

        //             // Validate.
        //             Validator::make($data, [
        //                 'score'         => "required|numeric|max:$maxScore",
        //                 'criteria_id'   => 'required|numeric',
        //             ]);

        //             // Check if task_id already exists in evaluation.
        //             $taskIDList = DB::table('evaluation')->select('task_id')->where('task_id', '<>', null)->get();
        //             $taskIDListArray = json_decode(json_encode($taskIDList), true);
        //             $temp = array();

        //             for ($i = 0; $i < count($taskIDListArray) - 1; $i++) {
        //                 array_push($temp, $taskIDListArray[$i]['task_id']);
        //             }

        //             if (!in_array($data['task_id'], $temp)){
        //                 try {
        //                     $evaluation->task_id = $data['task_id'] ?? null;
        //                     $evaluation->user_id = $data['user_id'] ?? null;
        //                     $evaluation->criteria_id = $data['criteria_id'];
        //                     $evaluation->score = $data['score'];
        //                     $evaluation->note = $data['note'];

        //                     $evaluation->save();

        //                     // Create Notification.
        //                     $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
        //                     $message = $userName[0]->name.' updated the evaluation.';

        //                     Notification::create([
        //                         'user_id'   => Auth::user()->id,
        //                         'type_id'   => 4,
        //                         'message'   => $message,
        //                         'content'   => json_encode($evaluation),
        //                         'has_seen'  => false,
        //                     ]);

        //                     // Update task status to EVALUATED.
        //                     if ($data['task_id']) {
        //                         Task::where('id', $data['task_id'])->update(['status_id' => 4]);
        //                     }
        //                 }
        //                 catch(Exception $e){
        //                     return response()->json([
        //                         'message' => $e->getMessage()
        //                     ], 500);
        //                 }
        //             } else {
        //                 return response()->json([
        //                     'message' => "The criteria_id value already exists with this same task_id. Please try another value."
        //                 ], 500);
        //             }
        //         }
        //         return response()->json([
        //             'message'   => 'Success'
        //         ], 200);
        //     }
        //     catch(Exception $e){
        //         return response()->json([
        //             'message' => $e->getMessage()
        //         ], 500);
        //     }
        // }
        // else{
        //     return response()->json([
        //         'message' => "You don't have access to this resource! Please contact with administrator for more information!"
        //     ], 403);
        // }



        // store in CriteriaController.
        // $role = Auth::user()->role;
        // if ($role > 2) {
        //     $this->validate($request, [
        //         'criteria_name'     => 'required|max:255',
        //         'criteria_type_id'  => 'required',
        //         'max_score'         => 'required',
        //     ]);

        //     try{
        //         $criteria = Criteria::create([
        //             'criteria_name'     => request('criteria_name'),
        //             'criteria_type_id'  => request('criteria_type_id'),
        //             'description'       => (request('description') !== null) ? request('description') : "",
        //             'max_score'         => request('max_score'),
        //             'task_id'           => (request('criteria_type_id') == 1) ? request('task_id') : null,
        //             'user_id'           => (request('criteria_type_id') == 2) ? request('user_id') : null
        //         ]);

        //         // Create Notification.
        //         $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
        //         $message = $userName[0]->name.' created a new criteria: '.request('criteria_name');

        //         Notification::create([
        //             'user_id'   => Auth::user()->id,
        //             'type_id'   => 3,
        //             'message'   => $message,
        //             'content'   => json_encode($criteria),
        //             'has_seen'  => false,
        //         ]);
        //         return response()->json([
        //             'data'    => $criteria,
        //             'message' => 'Success'
        //         ], 200);
        //     }
        //     catch(Exception $e){
        //         return response()->json([
        //             'message' => $e->getMessage()
        //         ], 500);
        //     }
        // }
        // else{
        //     return response()->json([
        //         'message' => "You don't have access to this resource! Please contact with administrator for more information!"
        //     ], 403);
        // }

        // getProjectsUserJoinedOrCreated in ProjectsController.
        // // Get id of the projects.
        // $projectIDArray = array();
        // foreach ($createdProjects as $crPj) {
        //     array_push($projectIDArray, $crPj['id']);
        // }

        // // Get total number of tasks in projects with above id.
        // $tasksInProject = Task::whereIn('project_id', $projectIDArray)->get();

        // // Count the total number of tasks.
        // $totalTasks = $tasksInProject->count();

        // // Count the number of evaluated and rejected tasks.
        // $evaluatedTasksCount = $rejectedTasksCount = 0;

        // foreach ($tasksInProject as $tskPj) {
        //     if ($tskPj['status_id'] === 4) {
        //         $evaluatedTasksCount++;
        //     }
        //     if ($tskPj['status_id'] === 5) {
        //         $rejectedTasksCount++;
        //     }
        // }

        // // Calculate progress value and Round to 2 decimal places.
        // $progress = round($evaluatedTasksCount / ($totalTasks - $rejectedTasksCount), 2) * 100;

        // // Add progress field to the result.
        // $createdProjects['progress'] = $progress;
    }

    public function test()
    {
        // $receiverID = DB::table('tasks')->select('assignee_id')->where('id', 21)->get();
        // $id = json_decode(json_encode($receiverID), true);
        // $finalID = $id[0]['assignee_id'];

        // $finalID = Task::findOrFail(21)->assignee_id;
        // return response()->json([
        //     'data'      => ($finalID),
        //     'message'   => "Success"
        // ], 200);

        $users = DB::table('users')->offset(7)->limit(5)->get();
        return response()->json([
            'data'      => $users,
            'message'   => "Success"
        ], 200);
    }
}
