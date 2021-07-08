<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Task;
use App\Notification;
use App\Jobs\NotificationJob;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;
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
        $dataArray = $request->all();

        // Result variable.
        $result = array();

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
                    try {
                        $criteria = Criteria::create([
                            'criteria_name'     => $data['criteria_name'],
                            'criteria_type_id'  => $data['criteria_type_id'],
                            'description'       => $data['description'] ?? "",
                            'max_score'         => $data['max_score'],
                            'task_id'           => $data['task_id'] ?? null,
                            'user_id'           => $data['user_id'] ?? null,
                        ]);

                        // Get this criteria and add to the result.
                        $maxCriteriaID = DB::table('criteria')->max('id');
                        $temp = DB::table('criteria')->where('id', $maxCriteriaID)->get()->toArray();
                        $result = array_merge($result, $temp);

                        // // Create Notification.
                        // $message = Auth::user()->name.' created a new criteria: '.$data['criteria_name'];

                        // $notification = ([
                        //     'user_id'       => Auth::user()->id,
                        //     'type_id'       => 3,
                        //     'message'       => $message,
                        //     'content'       => json_encode($criteria),
                        //     'receiver_id'   => 0,
                        //     'has_seen'      => false,
                        // ]);

                        // // Dispatch to NotificationJob.
                        // NotificationJob::dispatch($notification);
                    }
                    catch(Exception $e){
                        return response()->json([
                            'message' => $e->getMessage()
                        ], 500);
                    }
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

                $criteria->user_id = request('user_id') ?? null;
                $criteria->task_id = request('task_id') ?? null;

                $criteria->description = request('description') ?? "";
                $criteria->max_score = request('max_score');
                $criteria->save();

                // // Create Notification.
                // $message = Auth::user()->name.' updated the '.request('criteria_name').' criteria.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 3,
                //     'message'       => $message,
                //     'content'       => json_encode($criteria),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

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
        if ($role > 2) {
            try {
                // // Create Notification.
                // $message = Auth::user()->name.' deleted the '.$criteria->criteria_name.' criteria.';

                // $notification = ([
                //     'user_id'       => Auth::user()->id,
                //     'type_id'       => 3,
                //     'message'       => $message,
                //     'content'       => json_encode($criteria),
                //     'receiver_id'   => 0,
                //     'has_seen'      => false,
                // ]);

                // // Dispatch to NotificationJob.
                // NotificationJob::dispatch($notification);

                // Delete.
                $criteria->delete();

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

    public function getUserCriteriaByUserID(int $user_id, int $month, int $year)
    {
        try {
            $userCriteria = DB::table('criteria')
                ->where('user_id', $user_id)
                ->where('criteria_type_id', 2)
                ->whereMonth('created_at',$month)
                ->whereYear('created_at', $year)
                ->get()->toArray();

            // If the user is EVALUATED => Get evaluation data.
            if (DB::table('evaluation')->where('user_id', $user_id) !== null) {
                $evaluated = DB::table('criteria')
                    ->join('evaluation', 'evaluation.criteria_id', '=', 'criteria.id')
                    ->select('criteria.*', 'score', 'note')
                    ->where('evaluation.user_id', $user_id)
                    ->whereMonth('evaluation.created_at',$month)
                    ->whereYear('evaluation.created_at', $year)
                    ->get()->toArray();

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

    public function getTaskCriteriaList(Request $request)
    {
        try {
            if(isset($request->offset) && isset($request->limit))
            {
                $taskCriteria['data'] = DB::table('criteria')
                ->where('criteria_type_id', 1)->offset($request->offset)->limit($request->limit)
                ->orderByDesc('id')->get()->toArray();
                $count = DB::table('criteria')->where('criteria_type_id', 1)->get();
                $taskCriteria['count'] = $count->count();
            }
            else{
                $taskCriteria = DB::table('criteria')
                ->where('criteria_type_id', 1)->orderByDesc('id')->get()->toArray();
            }
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

    public function getUserCriteriaList(Request $request)
    {
        try {
            if(isset($request->offset) && isset($request->limit))
            {
                $userCriteria['data'] = DB::table('criteria')
                    ->where('criteria_type_id', 2)->offset($request->offset)->limit($request->limit)
                    ->orderByDesc('id')->get()->toArray();
                $count = DB::table('criteria')->where('criteria_type_id', 2)->get();
                $userCriteria['count'] = $count->count();
            }
            else{
                $userCriteria = DB::table('criteria')
                ->where('criteria_type_id', 2)->orderByDesc('id')->get()->toArray();
            }
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

    public function showCriteriaByOffsetAndLimit(int $offset, int $limit)
    {
        try {
            $criteria = DB::table('criteria')->offset($offset)->limit($limit)->get();
            return response()->json([
                'data'      => $criteria,
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
