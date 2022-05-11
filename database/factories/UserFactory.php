<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => env('INITIAL_USER_NAME'),
        'email' =>env('INITIAL_USER_EMAIL'),
        'password' => env('INITIAL_USER_PASSWORDHASH'),
        'remember_token' => str_random(10),
    ];
});
