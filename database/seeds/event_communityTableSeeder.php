<?php

use Illuminate\Database\Seeder;

class event_communityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_community')->insert([
            ['event_id' => '1', 'community_id' => '1', 'position' => 'organizer'],
        ]);
    }
}
