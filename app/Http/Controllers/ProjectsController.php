<?php

namespace App\Http\Controllers;

use App\Project;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        // $projects = request()->user()->projects;

        $pjs = Project::latest()->get();

        return view('projects.index', ['projects' => $pjs]);

        // return response()->json([
        //     'projects' => $pjs,
        // ], 200);
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
        $this->validate($request, [
            'project_name'  => 'required|max:255',
            'description'   => 'required',
        ]);

        $project = Project::create([
            'project_name'  => request('project_name'),
            'description'   => request('description'),
            'user_id'       => Auth::user()->id
        ]);

        // return response()->json([
        //     'project'    => $project,
        //     'message' => 'Success'
        // ], 200);

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
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
        //
        $this->validate($request, [
            'project_name'  => 'required|max:255',
            'description'   => 'required',
        ]);

        $project->project_name = request('project_name');
        $project->description = request('description');
        $project->save();

        return response()->json([
            'message' => 'Project updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully!'
        ], 200);
    }
}
