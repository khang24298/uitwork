<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;


$factory->define(Task::class, function (Faker $faker) {
    $priorities = array(
        0 => 'Low',
        1 => 'Normal',
        2 => 'High'
    );

    $startDate = $faker->dateTimeBetween('now', '+4 years');
    $endDate = $faker->dateTimeBetween($startDate->add(new DateInterval('P1D')), '+4 years');

    return [
        'user_id'       => rand(1,10),
        'assignee_id'   => rand(1,10),
        'task_name'     => $faker->name,
        'description'   => $faker->jobTitle,
        'start_date'    => $startDate,
        'end_date'      => $endDate,
        'status_id'     => rand(1,3),
        'qa_id'         => rand(1,50),
        'priority'      => $priorities[rand(0, count($priorities) - 1)]
    ];
});
