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
        $this->validate($request,[
            'task_id'     => 'required|numeric',
            'status_id'   => 'required|in:0',
            'content'     => 'required'
        ]);

        try{
            $task = Task::findOrFail($request['task_id']);
            $task->status_id = 5;
            $task->save();
            // Create notification bellow
            return response()->json([
                'data'      => true,
                'message'   => 'Refuse Success'
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
