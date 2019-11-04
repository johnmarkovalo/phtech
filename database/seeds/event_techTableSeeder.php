<?php

use Illuminate\Database\Seeder;

class event_techTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_tech')->insert([
            ['tech_id' => '5', 'event_id' => '1'],
            ['tech_id' => '6', 'event_id' => '1'],
            ['tech_id' => '7', 'event_id' => '1'],
            ['tech_id' => '8', 'event_id' => '1'],
        ]);
    }
}
