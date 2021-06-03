<?php

namespace App\Http\Controllers;

use App\Ranking;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
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
            $ranking = Ranking::all();

            return response()->json([
                'data'      => $ranking,
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
        if($role > 2) {
            $this->validate($request, [
                'user_id'                           => 'required|integer',
                'score_by_task_criteria'            => 'required|double',
                'score_by_personnel_criteria'       => 'required|double',
                'total_score'                       => 'required|double',
                'rank_by_task_criteria_score'       => 'required|integer',
                'rank_by_personnel_criteria_score'  => 'required|integer',
                'total_rank'                        => 'required|integer'
            ]);

            try {
                $ranking = Ranking::create([
                    'user_id'                           => request('user_id'),
                    'score_by_task_criteria'            => request('score_by_task_criteria'),
                    'score_by_personnel_criteria'       => request('score_by_personnel_criteria'),
                    'total_score'                       => request('total_score'),
                    'rank_by_task_criteria_score'       => request('rank_by_task_criteria_score'),
                    'rank_by_personnel_criteria_score'  => request('rank_by_personnel_criteria_score'),
                    'total_rank'                        => request('total_rank'),
                ]);
                return response()->json([
                    'data'      => $ranking,
                    'message'   => 'Success'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else {
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ranking  $ranking
     * @return \Illuminate\Http\Response
     */
    public function show(Ranking $ranking)
    {
        try{
            return response()->json([
                'data'      => $ranking,
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
     * @param  \App\Ranking  $ranking
     * @return \Illuminate\Http\Response
     */
    public function edit(Ranking $ranking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ranking  $ranking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ranking $ranking)
    {
        $role = Auth::user()->role;
        if($role > 2) {
            $this->validate($request, [
                'user_id'                           => 'required|integer',
                'score_by_task_criteria'            => 'required|double',
                'score_by_personnel_criteria'       => 'required|double',
                'total_score'                       => 'required|double',
                'rank_by_task_criteria_score'       => 'required|integer',
                'rank_by_personnel_criteria_score'  => 'required|integer',
                'total_rank'                        => 'required|integer'
            ]);

            try {
                $ranking->user_id = request('user_id');
                $ranking->score_by_task_criteria = request('score_by_task_criteria');
                $ranking->score_by_personnel_criteria = request('score_by_personnel_criteria');
                $ranking->total_score = request('total_score');

                $ranking->rank_by_task_criteria_score = request('rank_by_task_criteria_score');
                $ranking->rank_by_personnel_criteria_score = request('rank_by_personnel_criteria_score');
                $ranking->total_rank = request('total_rank');
                $ranking->save();

                return response()->json([
                    'data'      => $ranking,
                    'message'   => 'Ranking updated successfully!'
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
     * @param  \App\Ranking  $ranking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ranking $ranking)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $ranking->delete();
                return response()->json([
                    'message' => 'Ranking deleted successfully!'
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

    function delete_column(&$array, $offset) {
        return array_walk($array, function (&$v) use ($offset) {
            array_splice($v, $offset, 1);
        });
    }

    public function getUserRankByTaskCriteriaScore(int $user_id)
    {
        try {
            $userRankByTaskCriteriaScore = DB::table('rankings')
                ->select('rank_by_task_criteria_score')
                ->where('user_id', $user_id)->get();

            return response()->json([
                'data'      => $userRankByTaskCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserRankByPersonnelCriteriaScore(int $user_id)
    {
        try {
            $userRankByPersonnelCriteriaScore = DB::table('rankings')
                ->select('rank_by_personnel_criteria_score')
                ->where('user_id', $user_id)->get();

            return response()->json([
                'data'      => $userRankByPersonnelCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserTotalRank(int $user_id)
    {
        try {
            $userTotalRank = DB::table('rankings')
                ->select('total_rank')
                ->where('user_id', $user_id)->get();

            return response()->json([
                'data'      => $userTotalRank,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTaskCriteriaScoreRankList()
    {
        try {

            // Get task criteria score group by task id.
            $taskCriteriaScore = DB::table('tasks')
                ->join('users', 'tasks.assignee_id', '=', 'users.id')
                ->join('evaluation', 'tasks.id', '=', 'evaluation.task_id')
                ->select('users.name', 'tasks.assignee_id as user_id', 'evaluation.task_id',
                    DB::raw('SUM(score) as totalScore'))
                ->groupBy('evaluation.task_id')
                ->orderByDesc('totalScore')->get();

            // Group into one user.
            $taskCriteriaScoreClone = clone $taskCriteriaScore;
            $tempIndex = array();

            for ($i = 0; $i < count($taskCriteriaScore); $i++) {
                for ($j = $i + 1; $j < count($taskCriteriaScore); $j++) {
                    if ($taskCriteriaScore[$i]->user_id == $taskCriteriaScore[$j]->user_id) {
                        $taskCriteriaScoreClone[$i]->totalScore = $taskCriteriaScore[$i]->totalScore
                            + $taskCriteriaScore[$j]->totalScore;
                        array_push($tempIndex, $j);
                    }
                }
            }

            // Delete same users.
            foreach ($tempIndex as $index) {
                unset($taskCriteriaScoreClone[$index]);
            }

            // Convert to Array.
            foreach($taskCriteriaScoreClone as $object) {
                $userRankByTaskCriteriaScore[] = (array) $object;
            }

            // Delete unused columns.
            $this->delete_column($userRankByTaskCriteriaScore, 2);

            // Sort by rank.
            usort($userRankByTaskCriteriaScore, function($a, $b) {
                return $b['totalScore'] <=> $a['totalScore'];
            });

            // Add rank field.
            for ($i = 0; $i < count($userRankByTaskCriteriaScore); $i++) {
                $userRankByTaskCriteriaScore[$i]['rank'] = $i + 1;
            }

            return response()->json([
                'data'      => $userRankByTaskCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPersonnelCriteriaScoreRankList()
    {
        try {

            // Get personnel criteria score group by user id.
            $personnelCriteriaScore = DB::table('evaluation')
                ->join('users', 'users.id', '=', 'evaluation.user_id')
                ->select('evaluation.user_id', 'users.name', DB::raw('SUM(score) AS totalScore'))
                ->groupBy('user_id')
                ->orderByDesc('totalScore')->get();

            // Convert to Array.
            foreach($personnelCriteriaScore as $object) {
                $userRankByPersonnelCriteriaScore[] = (array) $object;
            }

            // Delete unused columns.
            // $this->delete_column($userRankByUserCriteriaScore, 0);

            // Add rank field.
            for ($i = 0; $i < count($userRankByPersonnelCriteriaScore); $i++) {
                $userRankByPersonnelCriteriaScore[$i]['rank'] = $i + 1;
            }

            return response()->json([
                'data'      => $userRankByPersonnelCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserTotalRankList()
    {
        try {
            $userID = DB::table('users')->select('id')->get();

            // Convert $userID to Array.
            foreach($userID as $object) {
                $userIDArrays[] = (array) $object;
            }

            $totalRank = array();
            // $totalRank = array('ranking' => array());
            // $totalRank = array('user_id' => array(), 'score' => array());

            foreach ($userIDArrays as $user_id) {

                $score_1 = DB::table('evaluation')->where('user_id', $user_id)->sum('score');

                $userTask = DB::table('users')
                    ->join('tasks', 'users.id', '=', 'tasks.assignee_id')
                    ->select('users.id AS userID', 'users.name', 'tasks.id')
                    ->toSql();

                $score_2 = DB::table('evaluation')
                    ->joinSub($userTask, 'user_task', function($join) {
                        $join->on('evaluation.task_id', '=', 'user_task.id');
                    })
                    ->select('user_task.name', 'evaluation.score')
                    ->where('user_task.userID', $user_id)->sum('score');

                $totalScore = $score_1 + $score_2;

                // Get user name by user id.
                $userName = DB::table('users')->select('name')->where('users.id', $user_id)->get();

                $newRanking = array(
                    'user_id'       => $user_id['id'],
                    'user_name'     => $userName[0]->name,
                    'totalScore'    => $totalScore
                );

                array_push($totalRank, $newRanking);

                // array_push($totalRank['user_id'], $user_id['id']);
                // array_push($totalRank['totalScore'], $totalScore);
            }

            // Sort by totalScore.
            usort($totalRank, function($a, $b) {
                return $b['totalScore'] <=> $a['totalScore'];
            });

            // Add rank field.
            for ($i = 0; $i < count($totalRank); $i++) {
                $totalRank[$i]['rank'] = $i + 1;
            }

            return response()->json([
                'data'      => $totalRank,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function insertToDatabase()
    {
        try {
            // Get user id list.
            $userID = DB::table('users')->select('id')->get();

            // Convert $userID to Array.
            foreach($userID as $object) {
                $userIDArrays[] = (array) $object;
            }

            // Insert for all user.
            foreach ($userIDArrays as $user_id)
            {
                $temp = $this->calcValuesForOneUser($user_id['id']);

                $userRankValues = json_decode(json_encode($temp), true)['original']['data'];

                // Get current date and time.
                date_default_timezone_set('Asia/Ho_Chi_Minh');
	            $date = date('Y-m-d h:i:s');

                DB::table('rankings')->insert([
                    'user_id'                           => $user_id['id'],
                    'score_by_task_criteria'            => $userRankValues[0],
                    'score_by_personnel_criteria'       => $userRankValues[1],
                    'total_score'                       => $userRankValues[2],
                    'rank_by_task_criteria_score'       => $userRankValues[3],
                    'rank_by_personnel_criteria_score'  => $userRankValues[4],
                    'total_rank'                        => $userRankValues[5],
                    'created_at'                        => $date,
                    'updated_at'                        => $date
                ]);
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
    }

    public function testInsert(int $user_id)
    {
        try {
            $temp = $this->calcValuesForOneUser($user_id);
            $userRankValues = json_decode(json_encode($temp), true)['original']['data'];

            // Get current date and time.
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('Y-m-d h:i:s');

            DB::table('rankings')->insert([
                'user_id'                           => $user_id,
                'score_by_task_criteria'            => $userRankValues[0],
                'score_by_personnel_criteria'       => $userRankValues[1],
                'total_score'                       => $userRankValues[2],
                'rank_by_task_criteria_score'       => $userRankValues[3],
                'rank_by_personnel_criteria_score'  => $userRankValues[4],
                'total_rank'                        => $userRankValues[5],
                'created_at'                        => $date,
                'updated_at'                        => $date
            ]);

            return response()->json([
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calcValuesForOneUser(int $user_id)
    {
        try {

            // Get first score and rank.
            $rankByTaskCriteriaScore = $this->getTaskCriteriaScoreRankList();

            $userRankByTaskCriteriaScore = json_decode(json_encode($rankByTaskCriteriaScore), true);

            $userFirstRankArray = $userRankByTaskCriteriaScore['original']['data'];

            for ($i = 0; $i < count($userFirstRankArray); $i++) {
                $userID = $userFirstRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $taskCriteriaScore = $userFirstRankArray[$i]['totalScore'];
                    $taskCriteriaRank = $userFirstRankArray[$i]['rank'];
                    break;
                }
            }

            // Get second score and rank.
            $rankByPersonnelCriteriaScore = $this->getPersonnelCriteriaScoreRankList();

            $userRankByPersonnelCriteriaScore = json_decode(json_encode($rankByPersonnelCriteriaScore), true);

            $userSecondRankArray = $userRankByPersonnelCriteriaScore['original']['data'];

            for ($i = 0; $i < count($userSecondRankArray); $i++) {
                $userID = $userSecondRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $personnelCriteriaScore = $userSecondRankArray[$i]['totalScore'];
                    $personnelCriteriaRank = $userSecondRankArray[$i]['rank'];
                    break;
                }
            }

            // Get total score and rank.
            $rankByTotalScore = $this->getUserTotalRankList();

            $userTotalRank = json_decode(json_encode($rankByTotalScore), true);

            $userTotalRankArray = $userTotalRank['original']['data'];

            for ($i = 0; $i < count($userTotalRankArray); $i++) {
                $userID = $userTotalRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $totalScore = $userTotalRankArray[$i]['totalScore'];
                    $totalRank = $userTotalRankArray[$i]['rank'];
                    break;
                }
            }

            $rankValues = array();
            array_push($rankValues, $taskCriteriaScore, $personnelCriteriaScore, $totalScore,
                $taskCriteriaRank, $personnelCriteriaRank, $totalRank);

            return response()->json([
                'data'      => $rankValues,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserRanking(int $user_id)
    {
        try {
            $userRankingInfo = DB::table('rankings')->where('user_id', $user_id)->get();
            return response()->json([
                'data'      => $userRankingInfo,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserRankingList()
    {
        try {
            $allUserRanking = DB::table('rankings')->get();
            return response()->json([
                'data'      => $allUserRanking,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserRankingListInUserDepartment()
    {
        try {
            $userDepartmentID = Auth::user()->department_id;
            $rankingInUserDepartment = DB::table('rankings')
                ->join('users', 'users.id', '=', 'rankings.user_id')
                ->select('rankings.*')
                ->where('department_id', $userDepartmentID)->get();

            return response()->json([
                'data'      => $rankingInUserDepartment,
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
