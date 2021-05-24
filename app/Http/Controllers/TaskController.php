<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\Task;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
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
            $tasks = Task::all();
            return response()->json([
                'data'      => $tasks,
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
            'task_name'         => 'required|max:255',
            'description'       => 'required',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'project_id'        => 'required',
            'assignee_id'       => 'required',
            'qa_id'             => 'required',
            'priority'          => 'required'
        ]);
        try{
            $task = Task::create([
                'task_name'     => request('task_name'),
                'description'   => request('description'),
                'user_id'       => Auth::user()->id,
                'project_id'    => request('project_id'),
                'assignee_id'   => request('assignee_id'),
                'start_date'    => request('start_date'),
                'end_date'      => request('end_date'),
                'status_id'     => 0,
                'qa_id'         => request('qa_id'),
                'priority'      => request('priority')
            ]);

            // Create Notification.
            $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
            $message = $userName[0]->name.' created a new task: '.request('task_name');

            Notification::create([
                'user_id'   => Auth::user()->id,
                'type_id'   => 2,
                'message'   => $message,
                'content'   => json_encode($task),
                'has_seen'  => false,
            ]);

            return response()->json([
                'data'      => $task,
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        try{
            return response()->json([
                'data'      => $task,
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    public function updateTaskStatus(Request $request){
        $this->validate($request, [
            'task_id'         => 'required|numeric',
            'status_id'       => 'required|in:0,1,2,3,4,6',
        ]);
        $role = Auth::user()->role;
        if($role <= 2 && in_array($request['status_id'],[0,6])){
            return response()->json([
                'data'      => null,
                'message'   => 'Permission Denied!'
            ], 200);
        }
        $task = Task::findOrFail($request['task_id']);
        $task->status_id = $request['status_id'];
        $task->save();
        return response()->json([
            'data'      => $task,
            'message'   => 'Update Success!'
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'task_name'         => 'required|max:255',
            'description'       => 'required',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'project_id'        => 'required',
            'assignee_id'       => 'required',
            'qa_id'             => 'required',
            'priority'          => 'required'
        ]);

        try{
            $task->task_name = request('task_name');
            $task->description = request('description');
            $task->assignee_id = request('assignee_id');
            $task->project_id = request('project_id');
            $task->start_date = request('start_date');
            $task->end_date = request('end_date');
            $task->status_id = request('status_id');
            $task->qa_id = request('qa_id');
            $task->user_id = Auth::user()->id;
            $task->priority = request('priority');

            $task->save();

            // Create Notification.
            $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
            $message = $userName[0]->name.' updated the '.request('task_name').' task.';

            Notification::create([
                'user_id'   => Auth::user()->id,
                'type_id'   => 2,
                'message'   => $message,
                'content'   => json_encode($task),
                'has_seen'  => false,
            ]);

            return response()->json([
                'data'      => $task,
                'message'   => 'Task updated successfully!'
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try{
            $task->delete();

            // Create Notification.
            $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
            $message = $userName[0]->name.' deleted the '.$task->project_name.' task.';

            Notification::create([
                'user_id'   => Auth::user()->id,
                'type_id'   => 2,
                'message'   => $message,
                'content'   => json_encode($task),
                'has_seen'  => false,
            ]);

            return response()->json([
                'message' => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTasksByAssignerOrAssignee(int $user_id)
    {
        try
        {
            $userRole = DB::table('users')->where('id', $user_id)->select('role')->get();

            // Convert to array.
            $userRoleArray = json_decode(json_encode($userRole), true);
            $userRoleValue = $userRoleArray[0]['role'];

            if ($userRoleValue > 2) {
                $tasksByAssigner = DB::table('tasks')->where('user_id', $user_id)->get();

                return response()->json([
                    'data'      => $tasksByAssigner,
                    'message'   => 'Success'
                ], 200);
            }
            else {
                $tasksByAssignee = DB::table('tasks')->where('assignee_id', $user_id)->get();

                return response()->json([
                    'data'      => $tasksByAssignee,
                    'message'   => 'Success'
                ], 200);
            }
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskInfo(int $task_id)
    {
        try {
            $taskInfo = DB::table('tasks')->where('id', $task_id)->get();

            return response()->json([
                'data'      => $taskInfo,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    *
    public function getReportByTaskID(int $task_id)
    {
        try {
            $reports = DB::table('tasks')->join('reports', 'tasks.id', '=', 'reports.task_id')
                ->select('title', 'content', 'type_id')
                ->where('tasks.id', $task_id)->get();

            return response()->json([
                'data'      => $reports,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskCriteriaByTaskID(int $task_id)
    {
        try {
            $taskCriteria = DB::table('tasks')->join('criteria', 'tasks.id', '=', 'criteria.task_id')
                ->select('criteria_name', 'criteria.description', 'criteria_type_id', 'score')
                ->where('tasks.id', $task_id)->get();

            return response()->json([
                'data'      => $taskCriteria,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getCommentByTaskID(int $task_id)
    {
        try {
            $taskComment = DB::table('tasks')->join('comments', 'comments.task_id', '=', 'tasks.id')
                ->select('content', 'task_name', 'description')
                ->where('tasks.id', $task_id)->get();

            return response()->json([
                'data'      => $taskComment,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDocumentByTaskID(int $task_id)
    {
        try {
            $taskDocument = DB::table('tasks')->join('documents', 'documents.task_id', '=', 'tasks.id')
                ->select('task_name', 'description', 'file_name', 'size')
                ->where('tasks.id', $task_id)->get();

            return response()->json([
                'data'      => $taskDocument,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    */

    public function getTasksByStatusID(int $status_id)
    {
        try {
            $tasksByStatus = DB::table('tasks')->where('status_id', $status_id)->get();

            return response()->json([
                'data'      => $tasksByStatus,
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
