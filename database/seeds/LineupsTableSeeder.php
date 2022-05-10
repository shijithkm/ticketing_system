<?php

use Illuminate\Database\Seeder;

class LineupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Lineup::class, 30)->create();
    }
}
