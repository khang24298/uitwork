<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Jobs\NotificationJob;
use Illuminate\Http\Request;
use App\Task;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MailNotification;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Storage;
class TaskController extends Controller
{
    use Notifiable;

    //
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
        $role = Auth::user()->role;

        if ($role > 2) {
            $this->validate($request, [
                'task_name'         => 'required|max:255',
                'description'       => 'required',
                'start_date'        => 'required|date',
                'end_date'          => 'required|date|after:start_date',
                'project_id'        => 'required|numeric',
                'assignee_id'       => 'required|numeric',
                'qa_id'             => 'required|numeric',
                'priority'          => 'required'
            ]);

            try {
                $task = Task::create([
                    'task_name'             => request('task_name'),
                    'description'           => request('description'),
                    'user_id'               => Auth::user()->id,
                    'project_id'            => request('project_id'),
                    'assignee_id'           => request('assignee_id'),
                    'start_date'            => request('start_date'),
                    'end_date'              => request('end_date'),
                    'status_id'             => 0,
                    'qa_id'                 => request('qa_id'),
                    'priority'              => request('priority'),
                    'has_been_evaluated'    => false
                ]);

                // Create Notification.
                $message = Auth::user()->name.' has created a new task: '.request('task_name').' and assigned it to you.';

                $notification = ([
                    'user_id'       => Auth::user()->id,
                    'type_id'       => 2,
                    'message'       => $message,
                    'content'       => json_encode($task),
                    'receiver_id'   => request('assignee_id'),
                    'has_seen'      => false,
                ]);

                // Dispatch to NotificationJob.
                NotificationJob::dispatch($notification);

                // Test Mail
                // if (request('priority') === 'High') {

                //     $receiver = User::select('email')->where('id', request('assignee_id'))->get();
                //     $task->email = $receiver[0]->email;

                //     // $task->notify(new MailNotification());
                //     FacadesNotification::send($task, new MailNotification());
                // }

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
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
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

    public function updateTaskStatus(Request $request)
    {
        // Validate.
        $this->validate($request, [
            'task_id'   => 'required|numeric',
            'status_id' => 'required|in:0,1,2,3,4,6',
        ]);

        $role = Auth::user()->role;

        if ($role <= 2 && in_array($request['status_id'],[0,6])) {
            return response()->json([
                'data'      => null,
                'message'   => 'Permission Denied!'
            ], 200);
        }

        // Find and Update.
        $task = Task::findOrFail($request['task_id']);
        $task->status_id = $request['status_id'];
        $task->save();

        // Create Notification.
        $message = Auth::user()->name.' updated the '.$task->task_name.' task.';

        $notification = ([
            'user_id'       => Auth::user()->id,
            'type_id'       => 2,
            'message'       => $message,
            'content'       => json_encode($task),
            'receiver_id'   => $task->user_id,
            'has_seen'      => false,
        ]);

        // Dispatch to NotificationJob.
        NotificationJob::dispatch($notification);

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
        $role = Auth::user()->role;

        if ($role > 2) {
            $this->validate($request, [
                'task_name'         => 'required|max:255',
                'description'       => 'required',
                'start_date'        => 'required|date',
                'end_date'          => 'required|date|after:start_date',
                'project_id'        => 'required|numeric',
                'assignee_id'       => 'required|numeric',
                'qa_id'             => 'required|numeric',
                'priority'          => 'required'
            ]);

            try {
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
                $task->has_been_evaluated = request('has_been_evaluated');

                $task->save();

                // // Create Notification.
                // $message = Auth::user()->name.' updated the '.request('task_name').' task.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 2,
                //     'message'       => $message,
                //     'content'       => json_encode($task),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

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
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
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
        $role = Auth::user()->role;
        if($role > 2) {
            try {
                // // Create Notification.
                // $message = Auth::user()->name.' deleted the '.$task->task_name.' task.';

                // $notification = ([
                //     'user_id'        => Auth::user()->id,
                //     'type_id'        => 2,
                //     'message'        => $message,
                //     'content'        => json_encode($task),
                //     'receiver_id'    => 0,
                //     'has_seen'       => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

                // Delete.
                $task->delete();

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
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
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

    
    public function storeFiles(Request $request)
    {
        try {
            $params = $request->file('files');
            $url = [];
            foreach($params as $file){
                $filename = $file->getClientOriginalName();
                $filepath = Storage::disk('uploadfiles')->put($filename, $file);
                $url[] = env('APP_URL')."/upload/".$filepath;
            }

            return response()->json([
                'data'      => $url,
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

    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return 'caotanan1234@gmail.com';

        // Return email address and name...
        // return [$this->email_address => $this->name];
    }
}
