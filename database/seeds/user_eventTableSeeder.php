<?php

use Illuminate\Database\Seeder;

class user_eventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_event')->insert([
            ['user_id' => '2', 'event_id' => '1', 'position' => 'organizer'],
        ]);
    }
}
