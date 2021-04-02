<?php

namespace App\Http\Controllers;

use App\Report;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function index()
    {
        try{
            $reports = Report::latest()->get();

            return response()->json([
                'reports' => $reports,
                'message' => 'Success'
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
        if($role > 2){
            $this->validate($request, [
                'title'         => 'required|max:255',
                'content'       => 'required',
                'type_id'       => 'required',
                'task_id'       => 'nullable',
                'project_id'    => 'nullable',
            ]);

            try{
                $report = Report::create([
                    'title'         => request('title'),
                    'content'       => request('content'),
                    'type_id'       => request('type_id'),
                    'user_id'       => Auth::user()->id,
                    'task_id'       => request('task_id'),
                    'project_id'    => request('project_id'),
                ]);
                return response()->json([
                    'report'    => $report,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
        try{
            return response()->json([
                'report' => $report,
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'title'         => 'required|max:255',
                'content'       => 'required',
                'type_id'       => 'required',
                'task_id'       => 'nullable',
                'project_id'    => 'nullable',
            ]);

            try{
                $report->title = request('title');
                $report->content = request('content');
                $report->type_id = request('type_id');
                $report->task_id = request('task_id');
                $report->project_id = request('project_id');
                $report->user_id = Auth::user()->id;
                $report->save();

                return response()->json([
                    'report'  => $report,
                    'message' => 'Report updated successfully!'
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $report->delete();
                return response()->json([
                    'message' => 'Report deleted successfully!'
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

    public function getReportList()
    {
        try {
            $reports = DB::table('reports')->get();

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

    public function getTaskReport()
    {
        try {
            $taskReports = DB::table('reports')->where('task_id', '<>', null)->get();

            return response()->json([
                'taskReports'      => $taskReports,
                'message'      => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProjectReport()
    {
        try {
            $projectReports = DB::table('reports')->where('project_id', '<>', null)->get();

            return response()->json([
                'projectReports'    => $projectReports,
                'message'           => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskReportByTaskID(int $task_id)
    {
        try {
            $taskReport = DB::table('reports')->where('task_id', $task_id)->get();

            return response()->json([
                'taskReport'      => $taskReport,
                'message'      => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProjectReportByProjectID(int $project_id)
    {
        try {
            $projectReport = DB::table('reports')->where('project_id', $project_id)->get();

            return response()->json([
                'projectReport'      => $projectReport,
                'message'      => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
