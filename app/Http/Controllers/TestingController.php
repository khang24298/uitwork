<?php

namespace App\Http\Controllers;

use App\Testing;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class TestingController extends Controller
{
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
     * @param  \App\Testing  $testing
     * @return \Illuminate\Http\Response
     */
    public function show(Testing $testing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testing  $testing
     * @return \Illuminate\Http\Response
     */
    public function edit(Testing $testing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testing  $testing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testing $testing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testing  $testing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testing $testing)
    {
        //
    }

    public function draftFunction()
    {
        // $scoreByTaskID = DB::table('evaluation')
        //     ->join('tasks', 'tasks.id', '=', 'evaluation.task_id')
        //     ->select('task_id', 'tasks.user_id', DB::raw('SUM(score) AS totalScore'))
        //     ->where('task_id', '<>', null)
        //     ->groupBy('task_id')->toSql();

        // $firstDateOfMonth = date('01-m-Y');
        // $lastDateOfMonth = date('Y-m-t');

        // $timestamp = strtotime($task_id->created_at->jsonSerialize());
        // $date = date('d-m-Y', $timestamp);
        // Get user list.
        // $userID = DB::table('users')->select('id')->get();

        // Test get first rank value.
        // $rankByTaskCriteriaScore = $this->getTaskCriteriaScoreRankList();

        // $userRankByTaskCriteriaScore = json_decode(json_encode($rankByTaskCriteriaScore), true);

        // $userRankArray = $userRankByTaskCriteriaScore['original']['userRank'];

        // for ($i = 0; $i < count($userRankArray); $i++) {
        //     $userID = $userRankArray[$i]['user_id'];
        //     if ($userID == 6) {
        //         $firstRank = $userRankArray[$i]['rank'];
        //         break;
        //     }
        // }

        // return $firstRank;

        // $a = $this->calcValuesForOneUser(2);

        // $aArray = json_decode(json_encode($a), true)['original']['rankValues'];

        // return $aArray[0];


        // // Test get user role.
        // $userRole = DB::table('users')->where('id', 1)->select('role')->get();

        // // Convert to array.
        // $userRoleArray = json_decode(json_encode($userRole), true);
        // $userRoleValue = $userRoleArray[0]['role'];

        // $randomUserID = rand(1,10);

        // $randomTaskID = rand(1, 20);
        // $randomValue = [$randomTaskID, null];

        // $random = $randomValue[rand(0, count($randomValue) - 1)];
        // $a = DB::table('criteria')->select('id')->where('task_id', 17)->get();
        // $b = json_decode(json_encode($a), true);
        // return $b[array_rand($b,1)]['id'];

        // $roleArray = array(5,10,15,20);
        // $result =  $roleArray[array_rand($roleArray,1)];

        // return $result;

        $maxScore = DB::table('criteria')->select('max_score')->where('id', 1)->get();
        // $maxScoreInt = (int)$maxScore;
        $maxScoreArray = json_decode(json_encode($maxScore), true);
        $maxScoreInt = $maxScoreArray[0]['max_score'];

        return $maxScoreInt;
    }
}
