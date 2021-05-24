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
use Illuminate\Support\Facades\Validator;

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
        $role = Auth::user()->role;

        // DataType of criteria : Array.
        $dataArray = $request->criteria;
        // dd($dataArray);
        if ($role > 2) {
            try {
                foreach ($dataArray as $data) {
                    // Validate.
                    Validator::make($data, [
                        'criteria_name'     => 'required|max:255',
                        'criteria_type_id'  => 'required|numeric',
                        'max_score'         => 'required|numeric',
                    ]);
                    // Create.
                    // dd($data);
                    try {
                        $criteria = Criteria::create([
                            'criteria_name'     => $data['criteria_name'],
                            'criteria_type_id'  => $data['criteria_type_id'],
                            'description'       => (isset($data['description'])) ? $data['description'] : "",
                            'max_score'         => $data['max_score'],
                            'task_id'           => (isset($data['task_id'])) ? $data['task_id'] : null,
                            'user_id'           => (isset($data['user_id'])) ? $data['user_id'] : null,
                        ]);

                        // Create Notification.
                        $userName = DB::table('users')->select('name')->where('id', Auth::user()->id)->get();
                        $message = $userName[0]->name.' created a new criteria: '.$data['criteria_name'];

                        Notification::create([
                            'user_id'   => Auth::user()->id,
                            'type_id'   => 3,
                            'message'   => $message,
                            'content'   => json_encode($criteria),
                            'has_seen'  => false,
                        ]);
                    }
                    catch(Exception $e){
                        return response()->json([
                            'message' => $e->getMessage()
                        ], 500);
                    }
                }
                return response()->json([
                    'message'   => 'Success'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
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
        if ($role > 2) {
            $this->validate($request, [
                'criteria_name'     => 'required|max:255',
                'criteria_type_id'  => 'required|numeric',
                'max_score'         => 'required|numeric',
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

            // If the task is EVALUATED => Get evaluation data.
            if (DB::table('evaluation')->where('task_id', $task_id) !== null) {
                $taskEvaluated = DB::table('criteria')
                    ->join('evaluation', 'evaluation.criteria_id', '=', 'criteria.id')
                    ->select('criteria.*', 'score', 'note')
                    ->where('evaluation.task_id', $task_id)->get()->toArray();

                // Get tasks evaluated.
                $temp = array();
                foreach($taskEvaluated as $taskEtd)
                {
                    array_push($temp, $taskEtd->id);
                }

                // Get tasks unevaluated.
                $taskUnevaluated = DB::table('criteria')
                    ->where('task_id', $task_id)
                    ->whereNotIn('id', $temp)->get()->toArray();

                $result = array_merge($taskEvaluated, $taskUnevaluated);
            } else {
                $result = clone $taskCriteria;
            }

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

    public function getUserCriteriaByUserID(int $user_id)
    {
        try {
            $userCriteria = DB::table('criteria')
                ->where('user_id', $user_id)
                ->where('criteria_type_id', 2)->get()->toArray();

            // If the user is EVALUATED => Get evaluation data.
            if (DB::table('evaluation')->where('user_id', $user_id) !== null) {
                $evaluated = DB::table('criteria')
                    ->join('evaluation', 'evaluation.criteria_id', '=', 'criteria.id')
                    ->select('criteria.*', 'score', 'note')
                    ->where('evaluation.user_id', $user_id)->get()->toArray();

                // Get evaluated.
                $temp = array();
                foreach($evaluated as $etd)
                {
                    array_push($temp, $etd->id);
                }

                // Get unevaluated.
                $unevaluated = DB::table('criteria')
                    ->where('user_id', $user_id)
                    ->whereNotIn('id', $temp)->get()->toArray();

                $result = array_merge($evaluated, $unevaluated);
            } else {
                $result = clone $userCriteria;
            }

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

    public function getTaskCriteriaList()
    {
        try {
            $taskCriteria = DB::table('criteria')
                ->where('criteria_type_id', 1)->get()
                ->toArray();

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
                ->where('criteria_type_id', 2)->get()
                ->toArray();

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
