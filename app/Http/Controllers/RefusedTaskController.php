<?php

namespace App\Http\Controllers;

use App\RefusedTask;
use Illuminate\Http\Request;
use App\Task;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefusedTaskController extends Controller
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function show(RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function edit(RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefusedTask $refusedTask)
    {
        //
    }

    public function refuseTask(Request $request)
    {
        try{
            $refusedTask = RefusedTask::create([
                'task_id'       => request('task_id'),
                'user_id'       => Auth::user()->id,
                'project_id'    => request('project_id'),
                'content'       => request('content')
            ]);

            return response()->json([
                'data'      => true,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'data'      => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }
}
