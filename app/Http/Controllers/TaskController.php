<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
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
        // dd(request()->user());
        try{
            $tasks = Task::all();
            return response()->json([
                'tasks' => $tasks,
                'message' => 'Success'
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
            'priority'          => 'required',
        ]);

        try{
            $task = Task::create([
                'task_name'     => request('task_name'),
                'description'   => request('description'),
                'assignee_id'   => request('assignee_id'),
                'start_date'    => request('start_date'),
                'end_date'      => request('end_date'),
                'status_id'     => request('status_id'),
                'qa_id'         => request('qa_id'),
                'priority'      => request('priority'),
                'user_id'       => Auth::user()->id
            ]);

            return response()->json([
                'task'    => $task,
                'message' => 'Success'
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
                'task' => $task,
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
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
            'start_date'        => 'required',
            'end_date'          => 'required',
            'priority'          => 'required',
        ]);

        try{
            $task->task_name = request('task_name');
            $task->description = request('description');
            $task->assignee_id = request('assignee_id');
            $task->start_date = request('start_date');
            $task->end_date = request('end_date');
            $task->status_id = request('status_id');
            $task->qa_id = request('qa_id');
            $task->user_id = Auth::user()->id;
            $task->priority = request('priority');

            $task->save();

            return response()->json([
                    'message' => 'Task updated successfully!'
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
            return response()->json([
                'message' => 'Task deleted successfully!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserTaskInfoByUserID(int $user_id)
    {
        try {
            $userInfo = DB::table('tasks')->join('users', 'tasks.user_id', '=', 'users.id')
                ->select('name', 'email', 'task_name', 'description')
                ->where('tasks.user_id', $user_id)->get();

            return response()->json([
                'userInfo'      => $userInfo,
                'message'       => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getReportByTaskID(int $task_id)
    {
        try {
            $reports = DB::table('tasks')->join('reports', 'tasks.id', '=', 'reports.task_id')
                ->select('title', 'content', 'type_id')
                ->where('tasks.id', $task_id)->get();

            return response()->json([
                'reports'      => $reports,
                'message'      => 'Success'
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
                'taskCriteria'  => $taskCriteria,
                'message'       => 'Success'
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
                'taskComment'   => $taskComment,
                'message'       => 'Success'
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
                'taskDocument'   => $taskDocument,
                'message'        => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
