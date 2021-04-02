<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;


$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,10),
        'project_name' => $faker->title,
        'description' => $faker->paragraph,
    ];
});
