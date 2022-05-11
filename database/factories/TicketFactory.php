<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {

    $ticketType = $faker->randomElement(['GOLD','SILVER','PLATINUM']);

    return [
        'event_id' => $faker->numberBetween($min = 1, $max = 5),
        'ticket_type' => $ticketType,
        'capacity' =>  $faker->numberBetween($min = 200, $max = 500),
        'price' => $faker->numberBetween($min = 10, $max = 100),
    ];
});
