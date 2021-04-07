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
            $ranking = Ranking::get();

            return response()->json([
                'ranking' => $ranking,
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

            try{
                $ranking = Ranking::create([
                    'user_id'                       => Auth::user()->id,
                    'rank_by_task_criteria_score'   => request('rank_by_task_criteria_score'),
                    'rank_by_user_criteria_score'   => request('rank_by_user_criteria_score'),
                    'total_rank'                    => request('total_rank'),
                ]);
                return response()->json([
                    'ranking'   => $ranking,
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
     * @param  \App\Ranking  $ranking
     * @return \Illuminate\Http\Response
     */
    public function show(Ranking $ranking)
    {
        try{
            return response()->json([
                'ranking' => $ranking,
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
        if($role > 2){
            try{
                $ranking->user_id = Auth::user()->id;
                $ranking->rank_by_user_criteria_score = request('rank_by_user_criteria_score');
                $ranking->rank_by_task_criteria_score = request('rank_by_task_criteria_score');
                $ranking->total_rank = request('total_rank');
                $ranking->save();

                return response()->json([
                    'ranking'   => $ranking,
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
                'userRank'  => $userRankByTaskCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserRankByUserCriteriaScore(int $user_id)
    {
        try {
            $userRankByUserCriteriaScore = DB::table('rankings')
                ->select('rank_by_user_criteria_score')
                ->where('user_id', $user_id)->get();

            return response()->json([
                'userRank'  => $userRankByUserCriteriaScore,
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
                'userRank'  => $userTotalRank,
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
                ->join('users', 'tasks.user_id', '=', 'users.id')
                ->join('evaluation', 'tasks.id', '=', 'evaluation.task_id')
                ->select('users.name', 'tasks.user_id', 'evaluation.task_id',
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
                'userRank'  => $userRankByTaskCriteriaScore,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserCriteriaScoreRankList()
    {
        try {

            // Get user criteria score group by user id.
            $userCriteriaScore = DB::table('evaluation')
                ->join('users', 'users.id', '=', 'evaluation.user_id')
                ->select('evaluation.user_id', 'users.name', DB::raw('SUM(score) AS totalScore'))
                ->groupBy('user_id')
                ->orderByDesc('totalScore')->get();

            // Convert to Array.
            foreach($userCriteriaScore as $object) {
                $userRankByUserCriteriaScore[] = (array) $object;
            }

            // Delete unused columns.
            // $this->delete_column($userRankByUserCriteriaScore, 0);

            // Add rank field.
            for ($i = 0; $i < count($userRankByUserCriteriaScore); $i++) {
                $userRankByUserCriteriaScore[$i]['rank'] = $i + 1;
            }

            return response()->json([
                'userRank' => $userRankByUserCriteriaScore,
                'message'  => 'Success'
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
                    ->join('tasks', 'users.id', '=', 'tasks.user_id')
                    ->select('users.id AS userID', 'users.name', 'tasks.id')
                    ->toSql();

                $score_2 = DB::table('evaluation')
                    ->joinSub($userTask, 'user_task', function($join) {
                        $join->on('evaluation.task_id', '=', 'user_task.id');
                    })
                    ->select('user_task.name', 'evaluation.score')
                    ->where('user_task.userID', $user_id)->sum('score');

                $score = $score_1 + $score_2;

                // Get user name by user id.
                $userName = DB::table('users')->select('name')->where('users.id', $user_id)->get();

                $newRanking = array(
                    'user_id'   => $user_id['id'],
                    'user_name' => $userName[0]->name,
                    'score'     => $score
                );

                array_push($totalRank, $newRanking);

                // array_push($totalRank['user_id'], $user_id['id']);
                // array_push($totalRank['score'], $score);
            }

            // Sort by score.
            usort($totalRank, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            // Add rank field.
            for ($i = 0; $i < count($totalRank); $i++) {
                $totalRank[$i]['rank'] = $i + 1;
            }

            return response()->json([
                'userRank' => $totalRank,
                'message'  => 'Success'
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

                $userRankValues = json_decode(json_encode($temp), true)['original']['rankValues'];

                // Get current date and time.
                date_default_timezone_set('Asia/Ho_Chi_Minh');
	            $date = date('Y-m-d h:i:s');

                DB::table('rankings')->insert([
                    'user_id'                       => $user_id['id'],
                    'rank_by_task_criteria_score'   => $userRankValues[0],
                    'rank_by_user_criteria_score'   => $userRankValues[1],
                    'total_rank'                    => $userRankValues[2],
                    'created_at'                    => $date,
                    'updated_at'                    => $date
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

    public function calcValuesForOneUser(int $user_id)
    {
        try {

            // Get first rank.
            $rankByTaskCriteriaScore = $this->getTaskCriteriaScoreRankList();

            $userRankByTaskCriteriaScore = json_decode(json_encode($rankByTaskCriteriaScore), true);

            $userFirstRankArray = $userRankByTaskCriteriaScore['original']['userRank'];

            for ($i = 0; $i < count($userFirstRankArray); $i++) {
                $userID = $userFirstRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $firstRank = $userFirstRankArray[$i]['rank'];
                    break;
                }
            }

            // Get second rank.
            $rankByUserCriteriaScore = $this->getUserCriteriaScoreRankList();

            $userRankByUserCriteriaScore = json_decode(json_encode($rankByUserCriteriaScore), true);

            $userSecondRankArray = $userRankByUserCriteriaScore['original']['userRank'];

            for ($i = 0; $i < count($userSecondRankArray); $i++) {
                $userID = $userSecondRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $secondRank = $userSecondRankArray[$i]['rank'];
                    break;
                }
            }

            // Get total rank.
            $rankByTotalScore = $this->getUserTotalRankList();

            $userTotalRank = json_decode(json_encode($rankByTotalScore), true);

            $userTotalRankArray = $userTotalRank['original']['userRank'];

            for ($i = 0; $i < count($userTotalRankArray); $i++) {
                $userID = $userTotalRankArray[$i]['user_id'];
                if ($userID == $user_id) {
                    $totalRank = $userTotalRankArray[$i]['rank'];
                    break;
                }
            }

            $rankValues = array();
            array_push($rankValues, $firstRank, $secondRank, $totalRank);

            return response()->json([
                'rankValues'    => $rankValues,
                'message'       => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
