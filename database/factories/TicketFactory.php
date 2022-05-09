<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'event_id' => $faker->numberBetween($min = 1, $max = 30),
        'ticket_type' => $faker->text(5),
        'capacity' =>  $faker->numberBetween($min = 10, $max = 500),
        'price' => $faker->numberBetween($min = 10, $max = 100),
    ];
});
