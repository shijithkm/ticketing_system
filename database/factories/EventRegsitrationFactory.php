<?php

use Faker\Generator as Faker;

$factory->define(App\EventRegistration::class, function (Faker $faker) {
    return [
        'ticket_id' => $faker->numberBetween($min = 1, $max = 30),
        'name' =>  $faker->text(5),
        'email' =>  $faker->unique()->safeEmail,
        'mobile' => $faker->numberBetween($min = 100000000, $max = 200000000),
    ];
});
