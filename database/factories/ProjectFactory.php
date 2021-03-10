<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;


$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id' => rand(1000,2000),
        'project_name' => $faker->city,
        'description' => $faker->company,
    ];
});
