<?php

namespace App\Http\Controllers;

use App\Report;
use Exception;
use Illuminate\Http\Request;

use App\Task;
use App\Project;
use App\User;
use App\Ranking;


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
            $reports = Report::get();

            return response()->json([
                'data'      => $reports,
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
                    'data'      => $report,
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
        try{
            return response()->json([
                'data'      => $report,
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
                    'data'      => $report,
                    'message'   => 'Report updated successfully!'
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
                'data'      => $reports,
                'message'   => 'Success'
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
                'data'      => $taskReports,
                'message'   => 'Success'
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
                'data'      => $projectReports,
                'message'   => 'Success'
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
                'data'      => $taskReport,
                'message'   => 'Success'
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
                'data'      => $projectReport,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Get projects statics
    public function getProjectStaticsReport(Request $request){
        $params = $request->all();

        $type = $params["type"];
        $time = $params["time"];
       
        $user_id = Auth::user()->id;
        try {
            switch ($type){
                case "year": 
                    $date = date("Y-m-d",strtotime("- ".$time." years"));
                    break;
                case "month":
                    $date = date("Y-m-d",strtotime("- ".$time." months"));
                    break;
                case "day": 
                    $date =  date("Y-m-d",strtotime("- ".$time." days"));
                    break;
                default:
                    $date = date('Y-m-d');
                break;
            }
  
            $createdProjects = Project::where('user_id', $user_id)
                            ->whereDate('start_date','>=',$date)
                            ->orderByDesc('id')->get();
            $doneProject = 0;
            $lateProject = 0;

            foreach ($createdProjects as $crPj) {
                $tasksInProject = Task::where('project_id', $crPj['id'])
                                        ->whereDate('start_date','>=',$date)
                                        ->join('users', 'tasks.assignee_id', '=', 'users.id')
                                        ->select('users.id','tasks.status_id')
                                        ->get();

                // Count the total number of tasks.
                if($tasksInProject->count() != 0){
                    $totalTasks = $tasksInProject->count();

                    $arrayValues = array_values($tasksInProject->pluck('id')->toArray());
                    $usersInProject = count(array_unique($arrayValues));
                }
                else{
                    $totalTasks = 0;
                    $usersInProject = 0;
                }

                // Count the number of evaluated and rejected tasks.
                $evaluatedTasksCount 
                = $rejectedTasksCount 
                = $onHoldTasksCount 
                = $onGoingTasksCount 
                = $progress 
                = $taskPerUser
                = 0;

                if ($totalTasks === 0) {
                    $progress = 100;
                }
                else {
                    foreach ($tasksInProject as $tskPj) {
                        if ($tskPj['status_id'] === 4) {
                            $evaluatedTasksCount++;
                        }
                        if ($tskPj['status_id'] === 5) {
                            $rejectedTasksCount++;
                        }
                        if ($tskPj['status_id'] === 0) {
                            $onHoldTasksCount++;
                        }
                        if (in_array($tskPj['status_id'],[1,2,3])){
                            $onGoingTasksCount++;
                        }
                    }
                    $taskPerUser = round(($totalTasks - $rejectedTasksCount)/$usersInProject,2);
                    // Calculate progress value and Round to 2 decimal places.
                    $progress = round($evaluatedTasksCount / ($totalTasks - $rejectedTasksCount), 2) * 100;
                }

                // Add fields to the result.
                $crPj['total_tasks'] = $totalTasks;
                $crPj['on_hold_tasks'] = $onHoldTasksCount;
                $crPj['on_going_tasks'] = $onGoingTasksCount;
                $crPj['evaluated_tasks'] = $evaluatedTasksCount;
                $crPj['rejected_tasks'] = $rejectedTasksCount;
                $crPj['progress'] = $progress;
                $crPj['taskPerUser'] = $taskPerUser;
                $crPj['users']  = $usersInProject;
                if($progress == 100){
                    $doneProject++;
                }
                else{
                    if(strtotime($crPj["end_date"]) < strtotime("now")){
                        $lateProject++;
                    }
                }

            }
            return response()->json([
                'data'      => [
                    "total_project"     => $createdProjects->count(),
                    "done_project"      => $doneProject,
                    "on_going_project"  => $createdProjects->count() - $doneProject,
                    "late_project"      => $lateProject,
                    "detail"            => $createdProjects
                ],
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){

        }
    }

    // Get members statics
    public function getMembersStaticsReport(Request $request){
        $params = $request->all();

        $type = $params["type"];
        $time = $params["time"];
       
        $department = Auth::user()->department_id;
       
        
        $usersCollection = User::where('users.department_id',$department)
                                    ->where('users.role','<=',2)
                                    ->get();
        foreach($usersCollection as $item){
            $userArray[] = $item->id;
        }
        switch ($type){
            case "year": 
                $date = date("Y-m-d",strtotime("- ".$time." years"));

                $groupUserByTime = $usersCollection->where('created_at','>=',$date)->groupBy(function ($item, $key) {
                    return date("Y",strtotime($item['created_at']));
                })->toArray();
                $userGrowthByTime = [];
                foreach($groupUserByTime as $key => $item){
                    $userGrowthByTime[] = [
                        "key"   => $key,
                        "value" => $item
                    ];
                }

                $rankingCollection = Ranking::where('created_at','>=',$date)->get();
                $rankingByTime = $rankingCollection->groupBy(function ($item, $key) {
                    return date("Y",strtotime($item['created_at']));
                });
                $rankingRateByTime = [];
                foreach($rankingByTime as $key => $item){
                    $usersRankingCount = $item->unique('user_id')->count();
                    $userHigh = $item->sortDesc()->unique('user_id');
                    $countHigh = 0;
                    foreach($userHigh as $val){
                        if($val->total_score > 400){
                            $countHigh++;
                        }
                    }
                    $usersRateHigh = round(($countHigh/$usersRankingCount),2)*100;
                    $rankingRateByTime[] =[
                        "key"   =>$key,
                        "value" =>$usersRateHigh
                    ];
                }
              
                $tasks = Task::whereIn('assignee_id',$userArray)->get();
                $tasksEachUser = $tasks->where('start_date','>=',$date)->groupBy(function ($item, $key) {
                    return date("Y",strtotime($item['start_date']));
                });

                $taskReport = [];
                foreach($tasksEachUser as $key => $item){
                    $tasksCount = $item->count();
                    $usersCount = $item->groupBy('assignee_id')->count();
                    $percents = round($tasksCount/$usersCount,2);
                    $taskReport[] = [
                        "key"   => $key,
                        "value" => $percents
                    ];
                }

                break;
            case "month":
                $date = date("Y-m-d",strtotime("- ".$time." months"));

                //
                $groupUserByTime = $usersCollection->where('created_at','>=',$date)->groupBy(function ($item, $key) {
                    return date("m",strtotime($item['created_at']));
                })->toArray();
                $userGrowthByTime = [];
                foreach($groupUserByTime as $key => $item){
                    $userGrowthByTime[] = [
                        "key"   => $key,
                        "value" => $item
                    ];
                }
                //

                //
                $rankingCollection = Ranking::where('created_at','>=',$date)->get();
                $rankingByTime = $rankingCollection->groupBy(function ($item, $key) {
                    return date("m",strtotime($item['created_at']));
                });
                $rankingRateByTime = [];
                foreach($rankingByTime as $key => $item){
                    $usersRankingCount = $item->unique('user_id')->count();
                    $userHigh = $item->sortDesc()->unique('user_id');
                    $countHigh = 0;
                    foreach($userHigh as $val){
                        if($val->total_score > 400){
                            $countHigh++;
                        }
                    }
                    $usersRateHigh = round(($countHigh/$usersRankingCount),2)*100;
                    $rankingRateByTime[] =[
                        "key"   =>$key,
                        "value" =>$usersRateHigh
                    ];
                }
              
                $tasks = Task::whereIn('assignee_id',$userArray)->get();
                $tasksEachUser = $tasks->where('start_date','>=',$date)->groupBy(function ($item, $key) {
                    return date("m",strtotime($item['start_date']));
                });

                $taskReport = [];
                foreach($tasksEachUser as $key => $item){
                    $tasksCount = $item->count();
                    $usersCount = $item->groupBy('assignee_id')->count();
                    $percents = round($tasksCount/$usersCount,2);
                    $taskReport[] = [
                        "key"   => $key,
                        "value" => $percents
                    ];
                }
                //
                break;
            case "day":
                $date = date("Y-m-d",strtotime("- ".$time." days"));

                //
                $groupUserByTime = $usersCollection->where('created_at','>=',$date)->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['created_at']));
                })->toArray();
                $userGrowthByTime = [];
                foreach($groupUserByTime as $key => $item){
                    $userGrowthByTime[] = [
                        "key"   => $key,
                        "value" => $item
                    ];
                }
                //

                //
                $rankingCollection = Ranking::where('created_at','>=',$date)->get();
                $rankingByTime = $rankingCollection->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['created_at']));
                });
                $rankingRateByTime = [];
                foreach($rankingByTime as $key => $item){
                    $usersRankingCount = $item->unique('user_id')->count();
                    $userHigh = $item->sortDesc()->unique('user_id');
                    $countHigh = 0;
                    foreach($userHigh as $val){
                        if($val->total_score > 400){
                            $countHigh++;
                        }
                    }
                    $usersRateHigh = round(($countHigh/$usersRankingCount),2)*100;
                    $rankingRateByTime[] =[
                        "key"   =>$key,
                        "value" =>$usersRateHigh
                    ];
                }
              
                $tasks = Task::whereIn('assignee_id',$userArray)->get();
                $tasksEachUser = $tasks->where('start_date','>=',$date)->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['start_date']));
                });

                $taskReport = [];
                foreach($tasksEachUser as $key => $item){
                    $tasksCount = $item->count();
                    $usersCount = $item->groupBy('assignee_id')->count();
                    $percents = round($tasksCount/$usersCount,2);
                    $taskReport[] = [
                        "key"   => $key,
                        "value" => $percents
                    ];
                }
                //
                break;
            default:
                $date = date("Y-m-d");
                //
                $groupUserByTime = $usersCollection->where('created_at','>=',$date)->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['created_at']));
                })->toArray();
                $userGrowthByTime = [];
                foreach($groupUserByTime as $key => $item){
                    $userGrowthByTime[] = [
                        "key"   => $key,
                        "value" => $item
                    ];
                }
                //

                //
                $rankingCollection = Ranking::where('created_at','>=',$date)->get();
                $rankingByTime = $rankingCollection->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['created_at']));
                });
                $rankingRateByTime = [];
                foreach($rankingByTime as $key => $item){
                    $usersRankingCount = $item->unique('user_id')->count();
                    $userHigh = $item->sortDesc()->unique('user_id');
                    $countHigh = 0;
                    foreach($userHigh as $val){
                        if($val->total_score > 400){
                            $countHigh++;
                        }
                    }
                    $usersRateHigh = round(($countHigh/$usersRankingCount),2)*100;
                    $rankingRateByTime[] =[
                        "key"   =>$key,
                        "value" =>$usersRateHigh
                    ];
                }
              
                $tasks = Task::whereIn('assignee_id',$userArray)->get();
                $tasksEachUser = $tasks->where('start_date','>=',$date)->groupBy(function ($item, $key) {
                    return date("d",strtotime($item['start_date']));
                });

                $taskReport = [];
                foreach($tasksEachUser as $key => $item){
                    $tasksCount = $item->count();
                    $usersCount = $item->groupBy('assignee_id')->count();
                    $percents = round($tasksCount/$usersCount,2);
                    $taskReport[] = [
                        "key"   => $key,
                        "value" => $percents
                    ];
                }
                //
            break;
        }

        return response()->json([
            'data'      => [
                "userGroupByTime"     => $userGrowthByTime,
                "taskEachUsers"          => $taskReport,
                "rankingRateByTime"   => $rankingRateByTime,
            ],
            'message'   => 'Success'
        ], 200);
    }
}
