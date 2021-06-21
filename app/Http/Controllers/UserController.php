<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Project;
use App\Task;

class UserController extends Controller
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
        $users = User::all();
        return response()->json([
            'data'      => $users,
            'message'   => 'Success'
        ], 200);
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
    public function store(UserStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data'      => $user,
            'message'   => 'Success'
        ],200);
    }

    /**
     * Get current user.
     * @return \Illuminate\Http\Response
     */
    public function currentUser()
    {
        $user = Auth::user();
        return response()->json([
            'data'      => $user,
            'message'   => "Success"
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        //
    }

    public function getUserInfo(int $user_id)
    {
        try {
            $userInfo = DB::table('users')->where('id', $user_id)->get();

            return response()->json([
                'data'      => $userInfo,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsersWithEmployeeRole()
    {
        try {
            $userWithEmployeeRole = DB::table('users')->where('role', '<=', 2)->get();

            return response()->json([
                'data'      => $userWithEmployeeRole,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsersWithManagerRole()
    {
        try {
            $userWithManagerRole = DB::table('users')->where('role', '>', 2)->get();

            return response()->json([
                'data'      => $userWithManagerRole,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //
    public function getTheStatistics()
    {
        try {
            // Result variable.
            $result = array();

            // If user is a manager.
            if (Auth::user()->role > 2) {
                // Get projects in user's department.
                $projectsInUserDepartment = Project::whereIn('user_id', function($query) {
                    $userDepartmentID = Auth::user()->department_id;
                    $query->select('id')->from('users')->where('department_id', $userDepartmentID);
                })->select('id')->get();

                // Get total projects.
                $totalProject = $projectsInUserDepartment->count();

                // Get total tasks.
                $totalTask = Task::whereIn('project_id', $projectsInUserDepartment)->count();

                // Get total done tasks.
                $totalDoneTask = Task::whereIn('project_id', $projectsInUserDepartment)->whereIn('status_id', array(3,4))->count();

                // Get total rejected tasks.
                $totalRejectedTask = Task::whereIn('project_id', $projectsInUserDepartment)->where('status_id', 5)->count();
            }
            else {
                // Get total projects.
                $totalProject = Task::distinct()->where('assignee_id', Auth::user()->id)->count('project_id');

                // Get total tasks.
                $totalTask = Task::where('assignee_id', Auth::user()->id)->count();

                // Get total done tasks.
                $totalDoneTask = Task::where('assignee_id', Auth::user()->id)->whereIn('status_id', array(3,4))->count();

                // Get total rejected tasks.
                $totalRejectedTask = Task::where('assignee_id', Auth::user()->id)->where('status_id', 5)->count();
            }

            // Add values to result.
            $result['totalProject'] = $totalProject;
            $result['totalTask'] = $totalTask;
            $result['totalDoneTask'] = $totalDoneTask;
            $result['totalRejectedTask'] = $totalRejectedTask;

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
    }
}
