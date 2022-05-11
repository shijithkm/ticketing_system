<?php

use Illuminate\Database\Seeder;

class EventRegistrationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EventRegistration::class, 10)->create();
    }
}
