<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;


$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,10),
        'assignee_id' => rand(1,10),
        'name' => $faker->name,
        'description' => $faker->jobTitle,
    ];
});
