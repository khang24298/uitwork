<?php

namespace App\Http\Controllers;

use App\Project;
use App\Status;
use App\User;
use App\Notification;
use App\Jobs\NotificationJob;
use Exception;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Task;
class ProjectsController extends Controller
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
            $projects = Project::get();

            return response()->json([
                'data'      => $projects,
                'message'   => 'Success'
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function all()
    {
        // $projects = Project::latest()->get();

        // return view('projects.index', ['projects' => $projects]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
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
                'project_name'  => 'required|max:255',
                'description'   => 'required',
                'start_date'    => 'required|date',
                'end_date'      => 'required|date'
            ]);

            try{
                $project = Project::create([
                    'project_name'  => request('project_name'),
                    'description'   => request('description'),
                    'user_id'       => Auth::user()->id,
                    'start_date'    => request('start_date'),
                    'end_date'      => request('end_date')
                ]);

                // // Create Notification.
                // $message = Auth::user()->name.' created a new project: '.request('project_name').'.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 1,
                //     'message'       => $message,
                //     'content'       => json_encode($project),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

                return response()->json([
                    'data'      => $project,
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
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        try {

            $tasksByProject = Task::where('project_id',$project)->get()->toArray();
            return response()->json([
                'data'      => $tasksByProject,
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // return view('projects.edit', ['project' => $project]);
    }
    public function getProjectDetailPagination(Request $request){
        $this->validate($request, [
            'offset'      => 'required|numeric',
            'limit'       => 'required|numeric',
            'project_id'  => 'required|numeric'
        ]);
        try {
            $tasksByProject['data'] = Task::where('project_id',$request->project_id)
            ->offset($request->offset)->limit($request->limit)
            ->get()->toArray();
            $count = Task::where('project_id',$request->project_id)->get();
            $tasksByProject['count'] = $count->count();
            return response()->json([
                'data'      => $tasksByProject,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $role = Auth::user()->role;

        if ($role > 2) {
            $this->validate($request, [
                'project_name'  => 'required|max:255',
                'description'   => 'required',
            ]);

            try {
                $project->project_name = request('project_name');
                $project->description = request('description');
                $project->save();

                // // Create Notification.
                // $message = Auth::user()->name.' updated the '.request('project_name').' project.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 1,
                //     'message'       => $message,
                //     'content'       => json_encode($project),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

                return response()->json([
                    'data'      => $project,
                    'message'   => 'Project updated successfully!'
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
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $role = Auth::user()->role;

        if ($role > 2) {
            try {
                $project->delete();

                // // Create Notification.
                // $message = Auth::user()->name.' deleted the '.$project->project_name.' project.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 1,
                //     'message'       => $message,
                //     'content'       => json_encode($project),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

                return response()->json([
                    'message' => 'Project deleted successfully!'
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

    public function getTasksByProjectID(int $project_id)
    {
        try {
            if(Auth::user()->role > 2){
                $statuses = Status::orderBy('type_id','ASC')->get();
            }
            else{
                $statuses = Status::where('type_id','<','5')->orderBy('type_id','ASC')->get();
            }
            $tasksByProject = [];
            foreach($statuses as $status){
                $taskList = Task::where([
                    [
                        'status_id',$status->type_id
                    ],
                    [
                        'project_id',$project_id
                    ]
                    ])->get()->toArray();
                array_push($tasksByProject,(Object)[
                    "status" => $status,
                    "tasks" => $taskList
                ]);
            }
            return response()->json([
                'data'      => $tasksByProject,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProjectsUserJoinedOrCreated(int $user_id)
    {
        try {
            $userRole = DB::table('users')->where('id', $user_id)->first()->role;

            if ($userRole > 2) {
                $createdProjects = Project::where('user_id', $user_id)->orderByDesc('id')->get();

                foreach ($createdProjects as $crPj) {
                    $tasksInProject = Task::where('project_id', $crPj['id'])->get();

                    // Count the total number of tasks.
                    $totalTasks = $tasksInProject->count();

                    // Count the number of evaluated and rejected tasks.
                    $evaluatedTasksCount = $rejectedTasksCount = 0;

                    if ($totalTasks === 0) {
                        $progress = 100;
                    }
                    else {
                        foreach ($tasksInProject as $tskPj) {
                            if ($tskPj['status_id'] === 4) {
                                $evaluatedTasksCount++;
                            }
                            if ($tskPj['status_id'] === 5) {
                                $rejectedTasksCount++;
                            }
                        }

                        // Calculate progress value and Round to 2 decimal places.
                        $progress = round($evaluatedTasksCount / ($totalTasks - $rejectedTasksCount), 2) * 100;
                    }

                    // Add fields to the result.
                    $crPj['total_tasks'] = $totalTasks;
                    $crPj['evaluated_tasks'] = $evaluatedTasksCount;
                    $crPj['rejected_tasks'] = $rejectedTasksCount;
                    $crPj['progress'] = $progress;
                }

                return response()->json([
                    'data'      => $createdProjects,
                    'message'   => 'Success'
                ], 200);
            }
            else {
                $joinedProjects = DB::table('tasks')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->select('projects.*')
                    ->where('tasks.assignee_id', $user_id)->distinct()->get()->toArray();

                // Calculate values in each projects which user joined.
                foreach ($joinedProjects as $jnPr) {
                    $userTasksInProject = Task::where('project_id', $jnPr->id)
                        ->where('assignee_id', $user_id)->get();

                    // Count the total number of tasks.
                    $totalTasks = $userTasksInProject->count();

                    // Count the number of evaluated and rejected tasks.
                    $evaluatedTasksCount = $rejectedTasksCount = 0;

                    foreach ($userTasksInProject as $usrTskPj) {
                        if ($usrTskPj['status_id'] === 4) {
                            $evaluatedTasksCount++;
                        }
                        if ($usrTskPj['status_id'] === 5) {
                            $rejectedTasksCount++;
                        }
                    }

                    // Calculate progress value and Round to 2 decimal places.
                    $progress = round($evaluatedTasksCount / ($totalTasks - $rejectedTasksCount), 2) * 100;

                    // Add fields to the result.
                    $jnPr->total_tasks = $totalTasks;
                    $jnPr->evaluated_tasks = $evaluatedTasksCount;
                    $jnPr->rejected_tasks = $rejectedTasksCount;
                    $jnPr->progress = $progress;
                }

                return response()->json([
                    'data'      => $joinedProjects,
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

    public function getUsersJoinedProject(int $project_id)
    {
        try {
            $joinedUsers = DB::table('tasks')
                ->join('users', 'tasks.assignee_id', '=', 'users.id')
                ->select('users.*')
                ->where('tasks.project_id', $project_id)
                ->distinct()
                ->get();

            return response()->json([
                'data'      => $joinedUsers,
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
