<?php

namespace App\Http\Controllers;

use App\WorkProcess;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkProcessController extends Controller
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
            $workProcess = WorkProcess::latest()->get();

            return response()->json([
                'data'      => $workProcess,
                'message'   => 'Success'
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
                'process_name'          => 'required',
                'process_id'            => 'required',
                'status_id'             => 'required',
                'next_status_id'        => 'required',
                'prev_status_id'        => 'required',
                'department_id'         => 'required',
            ]);

            try{
                $workProcess = WorkProcess::create([
                    'process_name'      => request('process_name'),
                    'process_id'        => request('process_id'),
                    'status_id'         => request('status_id'),
                    'next_status_id'    => request('next_status_id'),
                    'prev_status_id'    => request('prev_status_id'),
                    'department_id'     => request('department_id'),
                ]);
                return response()->json([
                    'data'      => $workProcess,
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
     * @param  \App\WorkProcess  $workProcess
     * @return \Illuminate\Http\Response
     */
    public function show(WorkProcess $workProcess)
    {
        try{
            return response()->json([
                'data'      => $workProcess,
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
     * @param  \App\WorkProcess  $workProcess
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkProcess $workProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkProcess  $workProcess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkProcess $workProcess)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'process_name'          => 'required',
                'process_id'            => 'required',
                'status_id'             => 'required',
                'next_status_id'        => 'required',
                'prev_status_id'        => 'required',
                'department_id'         => 'required',
            ]);

            try{
                $workProcess->process_name = request('process_name');
                $workProcess->process_id = request('process_id');
                $workProcess->status_id = request('status_id');
                $workProcess->next_status_id = request('next_status_id');
                $workProcess->prev_status_id = request('prev_status_id');
                $workProcess->department_id = request('department_id');

                $workProcess->save();

                return response()->json([
                    'data'      => $workProcess,
                    'message'   => 'Work process updated successfully!'
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
     * @param  \App\WorkProcess  $workProcess
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkProcess $workProcess)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $workProcess->delete();
                return response()->json([
                    'message' => 'Work process deleted successfully!'
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
}
