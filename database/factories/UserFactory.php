<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $roleArray = array(1,2,3,4);
    $random_keys = array_rand($roleArray,1);

    $gender = ['male', 'female'];
    $phone = ['916-612-9537', '704-902-9852', '863-913-6344', '443-800-1706', '402-677-2469',
            '785-432-7159', '904-718-3342', '317-489-5444', '469-441-9729', '951-025-1473'];
    $dob = ['1964-07-03', '1965-01-02', '1970-04-21', '1979-04-01', '1988-04-24',
            '1974-06-21', '1978-12-13', '1981-12-26', '1985-10-21', '1990-08-03'];

    return [
        'name'                  => $faker->name,
        'email'                 => $faker->unique()->safeEmail,
        'email_verified_at'     => now(),
        'password'              => Hash::make('passUITWORK'), // password
        'role'                  => $roleArray[$random_keys],
        'remember_token'        => Str::random(10),
        'phone'                 => $phone[array_rand($phone,1)], // Add fields info
        'gender'                => $gender[array_rand($gender,1)],
        'dob'                   => $dob[array_rand($dob,1)],
        'position_id'           => rand(1,4),
        'education_level_id'    => rand(1,4),
        'department_id'         => rand(1,5),
        'has_been_evaluated'    => false
    ];
});
