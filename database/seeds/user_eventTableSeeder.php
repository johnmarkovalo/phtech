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
            ['user_id' => '2', 'event_id' => '1', 'position' => 'organizer', 'qrcode' => '11234567'],
            ['user_id' => '2', 'event_id' => '2', 'position' => 'organizer', 'qrcode' => '21234567'],
            ['user_id' => '4', 'event_id' => '2', 'position' => 'absent', 'qrcode' => '31234567'],
            ['user_id' => '2', 'event_id' => '3', 'position' => 'organizer', 'qrcode' => '41234567'],
            ['user_id' => '3', 'event_id' => '3', 'position' => 'going', 'qrcode' => '51234567'],
        ]);
    }
}
