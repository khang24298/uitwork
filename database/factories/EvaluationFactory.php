<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evaluation;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

$factory->define(Evaluation::class, function (Faker $faker) {

    // Random user_id and task_id.
    $randomUserID = rand(1,10);
    $randomTaskID = rand(1, 20);
    $randomValue = [$randomTaskID, null];

    $finalRandomTaskID = $randomValue[rand(0, count($randomValue) - 1)];

    $finalRandomUserID = is_numeric($finalRandomTaskID) ? null : $randomUserID;

    // Random criteria_id.
    if ($finalRandomTaskID == null) {
        $criteriaIDList = DB::table('criteria')->select('id')->where('user_id', $finalRandomUserID)->get();
    }
    else {
        $criteriaIDList = DB::table('criteria')->select('id')->where('task_id', $finalRandomTaskID)->get();
    }

    // Convert to array.
    $criteriaIDListArray = json_decode(json_encode($criteriaIDList), true);
    $randomCriteriaID = $criteriaIDListArray[array_rand($criteriaIDListArray,1)]['id'];

    // Get max_score.
    $maxScore = DB::table('criteria')->select('max_score')->where('id', $randomCriteriaID)->get();
    $maxScoreArray = json_decode(json_encode($maxScore), true);
    $maxScoreInt = $maxScoreArray[0]['max_score'];

    return [
        'task_id'       => $finalRandomTaskID,
        'user_id'       => $finalRandomUserID,
        'criteria_id'   => $randomCriteriaID,
        'score'         => rand(1, $maxScoreInt),
        'note'          => $faker->jobTitle
    ];
});
