<?php

namespace App\Http\Controllers;

use App\Project;
use Exception;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth.jwt');
    // }

    public function index()
    {   
        try{
            $projects = Project::latest()->get();

            return response()->json([
                'projects' => $projects,
                'message' => 'Success'
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMEssage()
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
        if($role > 2){
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
                return response()->json([
                    'project'    => $project,
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
                'message' => "You don't have access to this resource!
                            Please contact with adminitrator for more information!"
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
                'project' => $project,
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
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
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
        if($role > 2){
            $this->validate($request, [
                'project_name'  => 'required|max:255',
                'description'   => 'required',
            ]);
            try{
                $project->project_name = request('project_name');
                $project->description = request('description');
                $project->save();
                return response()->json([
                    'project' => $project,
                    'message' => 'Project updated successfully!'
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
                'message' => "You don't have access to this resource!
                            Please contact with adminitrator for more information!"
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
        if($role > 2){
            try{
                $project->delete();
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
                'message' => "You don't have access to this resource!
                            Please contact with adminitrator for more information!"
            ], 403);
        }
    }
}
