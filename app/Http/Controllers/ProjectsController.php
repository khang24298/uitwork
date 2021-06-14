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
            ]);

            try{
                $project = Project::create([
                    'project_name'  => request('project_name'),
                    'description'   => request('description'),
                    'user_id'       => Auth::user()->id
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
    public function show(Project $project)
    {
        // dd($project);
        try{
            return response()->json([
                'data'      => $project,
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
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // return view('projects.edit', ['project' => $project]);
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
            $userRole = DB::table('users')->where('id', $user_id)->select('role')->get();

            // Convert to array.
            $userRoleArray = json_decode(json_encode($userRole), true);
            $userRoleValue = $userRoleArray[0]['role'];

            if ($userRoleValue > 2) {
                $projectsCreated = DB::table('projects')->where('user_id', $user_id)->get();

                return response()->json([
                    'data'      => $projectsCreated,
                    'message'   => 'Success'
                ], 200);
            }
            else {
                $projectsJoined = DB::table('tasks')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->select('projects.*')
                    ->where('tasks.assignee_id', $user_id)->distinct()->get();

                return response()->json([
                    'data'      => $projectsJoined,
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
            $usersJoined = DB::table('tasks')
                ->join('users', 'tasks.user_id', '=', 'users.id')
                ->select('users.*')
                ->where('tasks.project_id', $project_id)
                ->get();

            return response()->json([
                'data'      => $usersJoined,
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
