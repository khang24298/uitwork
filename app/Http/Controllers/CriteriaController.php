<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Task;
use App\Notification;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
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
            $criteria = Criteria::get();

            return response()->json([
                'data'      => $criteria,
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
        //
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'criteria_name'     => 'required|max:255',
                'criteria_type_id'  => 'required',
                'max_score'         => 'required',
            ]);

            try{
                $criteria = Criteria::create([
                    'criteria_name'     => request('criteria_name'),
                    'criteria_type_id'  => request('criteria_type_id'),
                    'description'       => (request('description') !== null) ? request('description') : "",
                    'max_score'         => request('max_score'),
                    'task_id'           => (request('criteria_type_id') == 1) ? request('task_id') : null,
                    'user_id'           => (request('criteria_type_id') == 2) ? request('user_id') : null
                ]);

                // Create Notification.
                $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
                $message = $userName[0]->name.' created a new criteria: '.request('criteria_name');

                Notification::create([
                    'user_id'   => Auth::user()->id,
                    'type_id'   => 3,
                    'message'   => $message,
                    'content'   => json_encode($criteria),
                    'has_seen'  => false,
                ]);
                return response()->json([
                    'data'    => $criteria,
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
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $criteria = Criteria::findOrFail($id);
            return response()->json([
                'data'      => $criteria,
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
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Criteria $criteria)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'criteria_name'     => 'required|max:255',
                'criteria_type_id'  => 'required',
                'max_score'         => 'required',
            ]);

            try{
                $criteria->criteria_name = request('criteria_name');
                $criteria->criteria_type_id = request('criteria_type_id');

                $criteria->user_id = (request('criteria_type_id') == 2) ? request('user_id') : null;
                $criteria->task_id = (request('criteria_type_id') == 1) ? request('task_id') : null;

                $criteria->description = request('description');
                $criteria->max_score = request('max_score');
                $criteria->save();

                // Create Notification.
                $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
                $message = $userName[0]->name.' updated the '.request('criteria_name').' criteria.';

                Notification::create([
                    'user_id'   => Auth::user()->id,
                    'type_id'   => 3,
                    'message'   => $message,
                    'content'   => json_encode($criteria),
                    'has_seen'  => false,
                ]);

                return response()->json([
                    'data'      => $criteria,
                    'message'   => 'Criteria updated successfully!'
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
     * @param  \App\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $criteria->delete();

                // Create Notification.
                $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
                $message = $userName[0]->name.' deleted the '.$criteria->criteria_name.' criteria.';

                Notification::create([
                    'user_id'   => Auth::user()->id,
                    'type_id'   => 3,
                    'message'   => $message,
                    'content'   => json_encode($criteria),
                    'has_seen'  => false,
                ]);

                return response()->json([
                    'message' => 'Criteria deleted successfully!'
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

    public function getTaskCriteriaByTaskID(int $task_id)
    {
        try {
            $taskCriteria = DB::table('criteria')
                ->where('task_id', $task_id)
                ->where('criteria_type_id', 1)->get()->toArray();

            return response()->json([
                'data'      => $taskCriteria,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserCriteriaByUserID(int $user_id)
    {
        try {
            $userCriteria = DB::table('criteria')
                ->where('user_id', $user_id)
                ->where('criteria_type_id', 2)->get();

            return response()->json([
                'data'      => $userCriteria,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskCriteriaList()
    {
        try {
            $taskCriteria = DB::table('criteria')
                ->where('criteria_type_id', 1)->get();

            return response()->json([
                'data'      => $taskCriteria,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserCriteriaList()
    {
        try {
            $userCriteria = DB::table('criteria')
                ->where('criteria_type_id', 2)->get();

            return response()->json([
                'data'      => $userCriteria,
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
