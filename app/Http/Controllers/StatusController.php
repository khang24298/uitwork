<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatusController extends Controller
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
            if(Auth::user()->role > 2){
                $status = Status::get();
            }
            else{
                $status = Status::where('type_id','<','4')->orderBy('type_id','ASC')->get();
            }
            return response()->json([
                'data'      => $status,
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
        if ($role > 2) {
            $this->validate($request, [
                'name'      => 'required|max:20',
                'type_id'   => 'required|numeric|min:0|max|5',
            ]);

            try{
                $status = Status::create([
                    'name'      => request('name'),
                    'type_id'   => request('type_id'),
                ]);
                return response()->json([
                    'data'      => $status,
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
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        try{
            return response()->json([
                'data'      => $status,
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
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'name'      => 'required|max:20',
                'type_id'   => 'required|numeric|min:0|max|5',
            ]);

            try{
                $status->name = request('name');
                $status->type_id = request('type_id');
                $status->save();

                return response()->json([
                    'data'      => $status,
                    'message'   => 'Status updated successfully!'
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
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $status->delete();
                return response()->json([
                    'message' => 'Status deleted successfully!'
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

    public function getTaskByStatusID(int $status_id)
    {
        try {
            $taskByStatus = DB::table('status')->join('tasks', 'status.id', '=', 'tasks.status_id')
                ->select('task_name', 'description', 'name', 'user_id')
                ->where('status.id', $status_id)->get();

            return response()->json([
                'data'      => $taskByStatus,
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
