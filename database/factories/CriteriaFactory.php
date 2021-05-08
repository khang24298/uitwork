<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Criteria;
use Faker\Generator as Faker;

$factory->define(Criteria::class, function (Faker $faker) {

    $randomUserID = rand(1,10);

    $randomTaskID = rand(1, 20);
    $randomValue = [$randomTaskID, null];

    $random = $randomValue[rand(0, count($randomValue) - 1)];

    return [
        'task_id'           => $random,
        'user_id'           => is_numeric($random) ? null : $randomUserID,
        'max_score'         => rand(80, 100),
        'criteria_name'     => $faker->jobTitle,
        'criteria_type_id'  => rand(1,2),
        'description'       => $faker->jobTitle
    ];
});
