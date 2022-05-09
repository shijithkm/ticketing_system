<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'description'  => $faker->text(200),
        'event_start_date'  => $faker->dateTime(),
        'event_end_date'  => $faker->dateTime(),
    ];
});
