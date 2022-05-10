<?php

use Faker\Generator as Faker;

$factory->define(App\Lineup::class, function (Faker $faker) {
    return [
        'event_id' => $faker->numberBetween($min = 1, $max = 30),
        'topic' => $faker->text(50),
        'speaker'  => $faker->text(50),
        'event_time'  => $faker->dateTime(),
    ];
});
