<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evaluation;
use Faker\Generator as Faker;

$factory->define(Evaluation::class, function (Faker $faker) {

    $randomUserID = rand(1,10);

    $randomTaskID = rand(1, 20);
    $randomValue = [$randomTaskID, null];

    $random = $randomValue[rand(0, count($randomValue) - 1)];

    return [
        'task_id'   => $random,
        'user_id'   => is_numeric($random) ? null : $randomUserID,
        'score'     => rand(1, 30),
        'note'      => $faker->jobTitle
    ];
});
