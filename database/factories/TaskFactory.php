<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;


$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => rand(1000,2000),
        'assignee_id' => rand(1000,2000),
        'name' => $faker->name,
        'description' => $faker->jobTitle,
    ];
});
